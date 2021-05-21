<?php
class GVAR
{
    public static $GPIO_DOOR1 = 68; //NUC980_PC4
    public static $GPIO_DOOR2 = 66; //NUC980_PC2
    public static $GPIO_ALARM1 = 65; //NUC980_PC2
    public static $GPIO_ALARM2 = 66; //fake same as door
    public static $DOOR_TIMER = 2; //Door lock stays open for 2s

    public static $GPIO_BUTTON1 = 170; //NUC980_PF10
    public static $GPIO_BUTTON2 = 169; //NUC980_PF9 - CAT_PIN //contact input
    public static $GPIO_DOORSTATUS1 = 168; //NUC980_PF8 - PSU_PIN //psu input
    public static $GPIO_DOORSTATUS2 = 45; //NUC980_PB13 - TAMPER_PIN //tamp input

    //$RD1_RLED_PIN = 3; //NUC980_PA3   //reader1 rled output
    public static $RD1_GLED_PIN = 2; //NUC980_PA2   //reader1 gled output
    //$RD2_RLED_PIN = 11; //NUC980_PA11  //reader2 rled output
    public static $RD2_GLED_PIN = 10;  //NUC980_PA10  //reader2 gled output

    public static $BUZZER_PIN = 79;  //NUC980_PC15  //buzzer output
}

function setupGPIOInputs() {
    //
    shell_exec("echo ".GVAR::$GPIO_BUTTON1." > /sys/class/gpio/export");
    shell_exec("echo in > /sys/class/gpio/gpio".GVAR::$GPIO_BUTTON1."/direction");
    //
    shell_exec("echo ".GVAR::$GPIO_BUTTON2." > /sys/class/gpio/export");
    shell_exec("echo in > /sys/class/gpio/gpio".GVAR::$GPIO_BUTTON2."/direction");
    //
    shell_exec("echo ".GVAR::$GPIO_DOORSTATUS1." > /sys/class/gpio/export");
    shell_exec("echo in > /sys/class/gpio/gpio".GVAR::$GPIO_DOORSTATUS1."/direction");
    //
    shell_exec("echo ".GVAR::$GPIO_DOORSTATUS2." > /sys/class/gpio/export");
    shell_exec("echo in > /sys/class/gpio/gpio".GVAR::$GPIO_DOORSTATUS2."/direction");
    //
    shell_exec("echo ".GVAR::$BUZZER_PIN." > /sys/class/gpio/export");
    shell_exec("echo out > /sys/class/gpio/gpio".GVAR::$BUZZER_PIN."/direction");
    //
    return shell_exec("cat /sys/class/gpio/gpio".GVAR::$GPIO_BUTTON1."/value").":".
        shell_exec("cat /sys/class/gpio/gpio".GVAR::$GPIO_BUTTON2."/value").":".
        shell_exec("cat /sys/class/gpio/gpio".GVAR::$GPIO_DOORSTATUS1."/value").":".
        shell_exec("cat /sys/class/gpio/gpio".GVAR::$GPIO_DOORSTATUS2."/value").":".
        shell_exec("cat /sys/class/gpio/gpio".GVAR::$BUZZER_PIN."/value");
}

function checkAndHandleInputs() {
    //TODO add other controllers
    //checkAndHandleSensor(GVAR::$GPIO_BUTTON1, 1);
    checkAndHandleButton(GVAR::$GPIO_BUTTON1, 1, 1);
    checkAndHandleButton(GVAR::$GPIO_BUTTON2, 2, 1);
    checkAndHandleSensor(GVAR::$GPIO_DOORSTATUS1, 1, 1);
    checkAndHandleSensor(GVAR::$GPIO_DOORSTATUS2, 2, 1);

}

function checkAndHandleButton($gpio, $id, $controller_id) {
    if(getGPIO($gpio) == 1) {
        $name = "Button ".$id;
        mylog("handleSwitch ".$name);
        //find what door to open
        $door = find_door_for_button_id($id,$controller_id);
        openDoor($door->id);

        //save report
        saveReport("Unkown", "Opened ".$door->name." with ". $name);
    }
}
function checkAndHandleSensor($gpio, $id, $controller_id) {
    if(getGPIO($gpio) == 1) {
        $name = "Sensor ".$id;
        mylog("handleSensor ".$name);
        $pollTime = 1; //interval for checking if the door is closed again.
        $doorSensorTriggerTime =find_setting_by_name("alarm");

        //wait for the given trigger time, than check again
        sleep($doorSensorTriggerTime);
        if(getGPIO($gpio) == 1) {
            //find what alarm to open
            $alarm = find_alarm_for_sensor_id($id,$controller_id);
            $gid = ($alarm == 1) ? GVAR::$GPIO_ALARM1 :GVAR::$GPIO_ALARM1;
            setGPIO($gid, 1);
            //save report
            saveReport("Unkown", "Alarm ".$door->name." from ". $name);

            //check if the door is closed, to turn of the alarm
            while(true) {
                if(getGPIO($gpio) == 0) {
                    setGPIO($gid, 0);
                    saveReport("Unkown", "Alarm stopped for ".$door->name." from ". $name);
                    break;
                }
                sleep($pollTime);
            }
        }
    }
}

function handleUserAccess($user, $reader_id) {

    //Check maximum visits for user 
    if(!empty($user->max_visits) && $user->visit_count > $user->max_visits) {
        return "Maximum visits reached:  visits = ".$user->max_visits;
    }
    //Check start/end date for user 
    $now = new DateTime();
    $startDate = new DateTime($user->start_date);
    $endDate = new DateTime($user->end_date);
    //if($now > $endDate) {
    if ($now < $startDate || $now > $endDate) {
        return "Access has expired: Start date = ".$user->start_date." End date = ".$user->end_date;
    }

    //APB, if the user is back within APB time, deny access
    $lastSeen = new DateTime($user->last_seen, new DateTimeZone('Europe/Amsterdam'));
    $diff =  $now->getTimestamp() - $lastSeen->getTimestamp();
    $apb = find_setting_by_name('apb'); //apb is defined in seconds
    mylog("lastseen=".$lastSeen->format("c")." now=".$now->format("c")." diff=".$diff." seconds\n");
    if($diff < $apb) {
        return "APB restriction: no access within ".$diff." seconds, must be longer than ".$apb." seconds";
    }


    //Determin what door to open
    $door = find_door_for_reader_id($reader_id, 1);

    //check if the group/user has access for this door
    $tz = find_timezone_by_group_id($user->group_id, $door->id);
    mylog("group=".$user->group_id." door=".$door->id."=".$door->name."\n");
    mylog("name=".$tz->name." start=".$tz->start." end=".$tz->end."\n");

    //check if it is the right day of the week
    $weekday = $now->format('w');//0 (for Sunday) through 6 (for Saturday) 
    $weekdays = explode(",",$tz->weekdays);
    mylog("weekday=".$weekday."=".$tz->weekdays."\n");
    if(! in_array($weekday, $weekdays)) {
        return "Day of the week restriction: ".$weekday." is not in ".$tz->weekdays." ";
    }

    //check if it is the right time
    $begin = new DateTime($tz->start);
    $end = new DateTime($tz->end);
    if ($now < $begin || $now > $end) {
        return "Time of the day restriction: ".$now->format('H:m')." is not between ".$tz->start." and ".$tz->end;
    }
    
    //update last_seen en visit_count
    update_user_statistics($user);

    //open the door 
    openDoor($door->id, $reader_id);
    $msg = "Opened ". $door->name. " with Reader ".$reader_id;

    return $msg;    
}

/*
*   Open a door 
*   $door_id : id in the db
*   $reader_id : 0=No reader. 1 or 2 to determine which green led
*   Used by match_listener and webinterface
*/
function openDoor($door_id, $reader_id) {
    //Read settings
    $doorOpen=find_setting_by_name("door_open");
    $soundBuzzer=find_setting_by_name("sound_buzzer");
    //mylog("openDoor ".$doorOpen."=".$soundBuzzer."\t");
    
    //Also use the green led on the the reader, to give user feedback
    $gled = 0;
    if($reader_id == 1) {
        $gled = GVAR::$RD1_GLED_PIN;
    }
    if($reader_id == 2) {
        $gled = GVAR::$RD2_GLED_PIN;
    }

    mylog("Open Door ".$door_id." reader=".$reader_id." LED=".$gled." sound_buzzer=".$soundBuzzer." door_open=".$doorOpen."\n");
    //open lock
    openLock($door_id, 1);
    //turn on led and buzzer
    if($gled) setGPIO($gled, 1);
    if($soundBuzzer) setGPIO(GVAR::$BUZZER_PIN, 1);
    //wait some time. close lock
    sleep($doorOpen);
    //turn off led and buzzer
    if($gled) setGPIO($gled, 0);
    if($soundBuzzer) setGPIO(GVAR::$BUZZER_PIN, 0);
    return openLock($door_id, 0);
}

/*
*   Open a lock given a door_id 
*   $door_id : id in the db
*   $open : 1=open, 0=close
*   returns true if state was changed
*/
function openLock($door_id, $open) { 
    $gid = 0;
    //asign proper gpio's used for the door or Alarm
    if($door_id == 1) {
        $gid = GVAR::$GPIO_DOOR1;
    }
    if($door_id == 2) {
        $gid = GVAR::$GPIO_DOOR2;
    }
    //
    $currentValue = shell_exec("cat /sys/class/gpio/gpio".$gid."/value");
    //mylog("openLock ".$currentValue."=".$open."\n");
    if($currentValue != $open) {
        //mylog("STATE CHANGED=".$open);
        setGPIO($gid, $open);
        return true;
    }
    //TODO open locks on other controllers
    return false;
}

function setGPIO($gid, $state) {
    mylog("setGPIO ".$gid."=".$state."\t");
    if(! file_exists("/sys/class/gpio/gpio".$gid)) {
        mylog("init gid=".$gid);
        shell_exec("echo ".$gid." > /sys/class/gpio/export");
        shell_exec("echo out >/sys/class/gpio/gpio".$gid."/direction");
    }
    shell_exec("echo ".$state." >/sys/class/gpio/gpio".$gid."/value");
    
    return 1;    
}

function getGPIO($gpio) {
    return shell_exec("cat /sys/class/gpio/gpio".$gpio."/value");
}


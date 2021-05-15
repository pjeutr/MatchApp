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
    if(shell_exec("cat /sys/class/gpio/gpio".$gpio."/value") == 1) {
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
    if(shell_exec("cat /sys/class/gpio/gpio".$gpio."/value") == 1) {
        $name = "Sensor ".$id;
        mylog("handleSensor ".$name);

        //TODO how to find out the sensor is open for 1min - 15min
        //TODO how to disable alarm after sensor is closed again

        //find what alarm to open
        $alarm = find_alarm_for_sensor_id($id,$controller_id);
        setGPIO($GPIO_ALARM1, 1);

        //save report
        saveReport("Unkown", "Alarm ".$door->name." from ". $name);
    }
}

function handleUserAccess($user, $reader) {
    //APB, if the user is back within APB time, don't give access
    $lastSeen = new DateTime($user->last_seen);
    $now = new DateTime();
    $diff =  $now->getTimestamp() - $lastSeen->getTimestamp();
    $apb = find_setting_by_name('apb'); //apb is defined in seconds
    mylog("lastseen=".$user->last_seen." ago=".$diff."\n");
    if($diff < $apb) {
        return "APB restriction: no access within ".$diff." seconds, must be longer than ".$apb." seconds";
    }

    //update last_seen en visit_count
    update_user_statistics($user);

    $door = find_door_for_reader_id($reader,1);

    //check if the group/user has access
    $tz = find_timezone_by_group_id($user->group_id, $door->id);
    mylog("name=".$tz->name." start=".$tz->start." end=".$tz->end."\n");

    //TODO check door and timezone, from access record
    $msg = "Opened ". $door->name. " with Reader ".$reader;

    //open the door 
    openDoor($reader);
    
    return $msg;    
}

/*

door1
Reader1 Reader2
Switch1 Switch2 REX (Request to Exit).

-Tijdelijke Pincodes, geldigheid op tijd/datum of aantal keer
-export in csv, voor reports
-signalering wat mee doen

15. tijdsprofielen - risico dat een relais niet urenlang kan blijven ingeschakeld (specs opzoeken)
25. APB houdt in Anti-passback. Dus het doorgeven van een toegangspas aan een ander. Is wel meer van op internet te vinden als dit nog niet duidelijk is.
33. Volledig naar fabrieksinstelling te zetten met drukknop op print plaat (MH)
Heb ik in het begin met Wang over gehad, maar heb ik niks meer over gehoord. Zal nog eens navragen. Zit al PCB

*/

function openDoor($reader) {
    //Read settings
    $doorOpen=find_setting_by_id(1);
    $soundBuzzer=find_setting_by_id(2);
    //$doorOpen=GVAR::$DOOR_TIMER;
    //determine which reader is used, so we can select the proper led
    $gled = 0;
    $gid = 0;

    //determine the right door, assume reader1=door1, reader2=door2
    //TODO config reader2 to also open door 1?
    if($reader == 1) {
        $gled = GVAR::$RD1_GLED_PIN;
        $gid = GVAR::$GPIO_DOOR1;
    }
    if($reader == 2) {
        $gled = GVAR::$RD2_GLED_PIN;
        $gid = GVAR::$GPIO_DOOR2;
    }
    if($reader == 3) {
        $gid = GVAR::$GPIO_ALARM1;
    }
    mylog("Open Door GPIO=".$gid." reader=".$reader." LED=".$gled." sound_buzzer=".$soundBuzzer." door_open=".$doorOpen."\n");
    //open lock
    setGPIO($gid, 1);
    //turn on led and buzzer
    if($gled) setGPIO($gled, 1);
    if($soundBuzzer) setGPIO(GVAR::$BUZZER_PIN, 1);
    //wait some time. close lock
    sleep($doorOpen);
    //turn off led and buzzer
    if($gled) setGPIO($gled, 0);
    if($soundBuzzer) setGPIO(GVAR::$BUZZER_PIN, 0);
    return setGPIO($gid, 0);
}

function setGPIO($gid, $state) {
    mylog("setGPIO ".$gid."=".$state."\t");
    if(! file_exists("/sys/class/gpio/gpio".$gid)) {
        mylog("init gid=".$gid);
        shell_exec("echo ".$gid." > /sys/class/gpio/export");
        shell_exec("echo out >/sys/class/gpio/gpio".$gid."/direction");
    }
//led 40 & 45
//1 = off, 0 = on
//$gpio_on = shell_exec('gpio write 1 1');
// echo 40 > /sys/class/gpio/export
// echo out >/sys/class/gpio/gpio40/direction
// echo 1 >/sys/class/gpio/gpio40/value
//switch 90 & 92 not working propably needs a 4.7K pull-down resistor?
// cat /sys/class/gpio/gpio90/active_low    
// echo both > /sys/class/gpio/gpio90/edge
// rising / falling / both / none

    shell_exec("echo ".$state." >/sys/class/gpio/gpio".$gid."/value");
    
    return 1;    
}



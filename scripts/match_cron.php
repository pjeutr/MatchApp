#!/usr//bin/php
<?php

require_once '/maasland_app/www/lib/limonade.php';;
require_once '/maasland_app/www/lib/db.php';
require_once '/maasland_app/www/lib/helpers.php';
require_once '/maasland_app/www/lib/logic.door.php';
//load models for used db methods
require_once '/maasland_app/www/lib/model.report.php';
require_once '/maasland_app/www/lib/model.user.php';
require_once '/maasland_app/www/lib/model.settings.php';
require_once '/maasland_app/www/lib/model.door.php';
require_once '/maasland_app/www/lib/model.controller.php';
require_once '/maasland_app/www/lib/model.timezone.php';

//initialize database connection
$dsn = "sqlite:/maasland_app/www/db/dev.db";
$db = new PDO($dsn);
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
option('dsn', $dsn);
option('db_conn', $db);
option('debug', true);

$now = new DateTime();
$actor = "Cron"; 
$action = "Systemcheck ";
//find door->timezone_id fields	 

//check if everything is alive
//if($now->format('H:i') == "2:00") { //every night at 2
if($now->format('i') == 45) { //every hour

	exec("ps -o pid,user,comm,stat,args | grep -i 'match_listener' | grep -v grep", $pids);
	// D Uninterruptible sleep (usually IO)
	// R Running or runnable (on run queue)
	// S Interruptible sleep (waiting for an event to complete)
	// T Stopped, either by a job control signal or because it is being traced.
	// W paging (not valid since the 2.6.xx kernel)
	// X dead (should never be seen)
	// Z Defunct ("zombie") process, terminated but not reaped by its parent.

	if(empty($pids)) {
		$action = "match_listener not running!";
	} else {
	    $action = "Systemcheck, match_listener OK. ".count($pids)." pids:".join(',', $pids);
	}

	//check if listener still running?
	saveReport($actor, $action);
}

$doors = find_doors();
foreach ($doors as $door) {
	if($door->timezone_id) {
		echo "Door=".$door->name." - ".$door->timezone_id."\n";
		$tz = find_timezone_by_id($door->timezone_id);

	    //check if it is the right day of the week
	    $weekday = $now->format('w');//0 (for Sunday) through 6 (for Saturday) 
	    $weekdays = explode(",",$tz->weekdays);
	    mylog("weekday=".$weekday."=".$tz->weekdays."\n");
	    if(in_array($weekday, $weekdays)) {
	    	//check if it is the right time
		    $begin = new DateTime($tz->start);
		    $end = new DateTime($tz->end);
		    mylog($tz->name."=".$tz->start."=".$tz->end."\n");
		    if ($now >= $begin && $now <= $end) {
		    	$changed = openLock($door->id, 1);
		    	$action = "Automatically opened door ".$door->name." opened";
		    	if($changed) saveReport($actor, $action);
		    } else {
		    	$changed = openLock($door->id, 0);
		    	$action = "Automatically closed door  ".$door->name." closed";
		    	if($changed) saveReport($actor, $action);
		    }
	    } else {
	    	$changed = openLock($door->id, 0);
	    	$action = "Automatically closed door  ".$door->name." closed";
	    	if($changed) saveReport($actor, $action);
	    }

	}
}


	




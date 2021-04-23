<?php

require_once '/maasland_app/www/lib/limonade.php';;
require_once '/maasland_app/www/lib/db.php';
require_once '/maasland_app/www/lib/helpers.php';
require_once '/maasland_app/www/lib/model.report.php';
require_once '/maasland_app/www/lib/model.user.php';
require_once '/maasland_app/www/lib/model.door.php';

//initialize database connection
$dsn = "sqlite:/maasland_app/www/db/dev.db";
$db = new PDO($dsn);
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
option('dsn', $dsn);
option('db_conn', $db);
option('debug', true);

$r = setupGPIOInputs();
echo "setupGPIOInputs=".$r;

$filename = "/sys/kernel/wiegand/read";
$current_contents = "";  

while(true) {
	global $current_contents;
    $new_contents = file_get_contents($filename).":".checkInputs();

    if (strcmp($new_contents, $current_contents)) {
		$current_contents = $new_contents;
		echo "Activity nr:key:reader:raw:switch ".$new_contents;

		$content = explode(":",$new_contents);
		$nr = $content[0];
		$keycode = $content[1];
		$reader = $content[2];
		$raw = $content[3];
		$switch = $content[4];

		
		if($reader==0) {
			$reader = $switch;
		}

		//save event
		$report = make_report_obj([
			"nr"  => $nr,
			"keycode"  => $keycode,
		    "reader" => $reader
		]);
		$id = create_object($report, 'events', null);

		//Button1 = -1, Button2 = -2
		//Reader1 = 1, Reader2 = 2
		if($reader < 0) {
			handleSwitch($reader);
		} else {
			//get User for the key
			$user = find_user_by_keycode($keycode);
			if($user) {
				handleUserAccess($user,$reader);
			}
		}
		//wait half a second, to avoid too much load on CPU
		usleep(500000);
    }
}



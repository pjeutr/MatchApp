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

$filename = "/sys/kernel/wiegand/read";
$current_contents = "";  

while(true) {
	global $current_contents;
    $new_contents = file_get_contents($filename);

    if (strcmp($new_contents, $current_contents)) {
		$current_contents = $new_contents;
		echo "Activity nr:key:reader:raw ".$new_contents;

		$content = explode(":",$new_contents);
		$nr = $content[0];
		$keycode = $content[1];
		$reader = $content[2];

		//save event
		$report = make_report_obj([
			"nr"  => $nr,
			"keycode"  => $keycode,
		    "reader" => $reader
		]);
		$id = create_object($report, 'events', null);

		//get User for the key
		$user = find_user_by_keycode($keycode);
		if($user) {
			handleUserAccess($user,$reader);
		}

		//wait a quarter of a second, to avoid too much load on CPU
		usleep(250000);
    }
}



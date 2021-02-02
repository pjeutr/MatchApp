<?php

/*
php -f match_listener.php id=12 key=1234 reader=2

id = incremental number, unique for the session
key = code typed by user or cartnumber/keycode
reader = 1 or 2 number of the port the reader is connected to

saveEvent(id, key)

bool canKeyOpenDoor(key, reader) {
	user = getUserByKey(key)
	if(user->canUserOpenDoor()) {
		return true;
	}
	return false
}

*/

require_once '/maasland_app/www/lib/limonade.php';
require_once '/maasland_app/www/lib/db.php';
require_once '/maasland_app/www/lib/helpers.php';

//put variables in $_GET
parse_str(implode('&', array_slice($argv, 1)), $_GET);
$nr = $_GET['nr'];
$key = $_GET['key'];
$reader = $_GET['reader'];

echo "nr=".$nr." key=".$key." reader=".$reader."\n";

$dsn = 'sqlite:/maasland_app/www/db/dev.db';
try {
	$db = new PDO($dsn);
	//save event
	$sql = "INSERT INTO events (nr,keycode,reader,created_at,updated_at) 
		VALUES ($nr, $key, $reader, DateTime('now'), DateTime('now'))";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	echo "id=".$db->lastInsertId()."\n";

	//TODO opendoor remove following hacks
	if($key == 1357) {
		createReportEntry($reader, $key);
		openDoor1($reader);
	}
	if($key == 2468) {
		openDoor2($reader);
	}
	if($key == 2581102) {
		openDoor1($reader);
	}
	if($key == 3451230) {
		openDoor2($reader);
	}
} catch(PDOException $e) {
	echo "Connection failed: ".$e;
}

function createReportEntry($door, $user) {
	$dsn = 'sqlite:/maasland_app/www/db/dev.db';
	$db = new PDO($dsn);
	//save event
	$sql = "INSERT INTO reports (door,user,created_at,updated_at) 
		VALUES ($door, $user, DateTime('now'), DateTime('now'))";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	echo "id=".$db->lastInsertId()."\n";
}
// $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
// option('db_conn', $db);

// setlocale(LC_TIME, "nl_NL");

// $users = find_object_by_sql("select name from users where id =1");
// echo $users->name;


?>
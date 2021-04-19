<?php

# GET /
function main_page() {
    return html('main.html.php');
}
function event_index() {
    set('events', find_events());
    return html('events.html.php');
}
function report_index() {
    set('reports', find_reports());
    return html('reports.html.php');
}
function timezone_index() {
    set('timezones', find_timezones());
    return html('timezones.html.php');
}
function settings_index() {
    set('settings', find_settings());
    return html('settings.html.php');
}
function settings_update() {
    $id = filter_var(params('id'), FILTER_VALIDATE_INT);
    $type = filter_var($_POST['setting_type'], FILTER_SANITIZE_STRING);
    $name = filter_var($_POST['setting_name'], FILTER_SANITIZE_STRING);

    if($type == 2) { //checkbox 
        $value = isset($_POST[$name])?1:0;
    } else {
        $value = filter_var($_POST[$name], FILTER_SANITIZE_STRING);
    }
    
    //name and id are both unique, we could use only one of those.
    $sql = "UPDATE settings SET value = ? WHERE id = ? AND name = ?";
    mylog("A setting was changed ".$id.":".$name."=".$value);
    
    $message = "{type: 'error' ,title: 'Oops', text: 'Something went wrong!'}";
    if(update_with_sql($sql, [$value,$id,$name])) {
        $message = "{type: 'success' ,title: 'Great', text: 'The Setting was changed!'}";
    }

    set('message', $message);
    set('settings', find_settings());
    return html('settings.html.php');
}

//ajax
function last_reports() {
    return (json(find_reports()));
}

//TODO ajaxify
//user render ipv html 
//render('index.html.php', null, array('name' => 'John Doe' ));
//of json($my_data);
function gpio_key() {
	return (rand(0, 1)) ? "button on" : "button off";
}

function gpio_state() {
	$id = filter_var(params('id'), FILTER_VALIDATE_INT);
	$state = filter_var(params('state'), FILTER_VALIDATE_INT);
	setGPIO($id, $state);
    return html('dashboard.html.php');
}

function door_open() {
	$id = filter_var(params('id'), FILTER_VALIDATE_INT);
    saveReport("WebAdmin", "Opened door ".$id);
    openDoor($id);
    return html('dashboard.html.php');
}


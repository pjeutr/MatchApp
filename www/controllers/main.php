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


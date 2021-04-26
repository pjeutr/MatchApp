<?php

function find_events() {
    return find_objects_by_sql("SELECT * FROM `events`");
}

function find_event_by_id($id) {
    $sql =
        "SELECT * " .
        "FROM events " .
        "WHERE id=:id";
    return find_object_by_sql($sql, array(':id' => $id));
}

function get_last_scanned_key() {
    return find_string_by_sql("SELECT keycode FROM events ORDER BY id DESC LIMIT 1"); 
}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

function update_event_obj($event_obj) {
    return update_object($event_obj, 'events', event_columns());
}

function create_event_obj($event_obj) {
    return create_object($event_obj, 'events', event_columns());
}

function delete_event_obj($man_obj) {
    delete_object_by_id($man_obj->id, 'events');
}

function delete_event_by_id($event_id) {
    delete_object_by_id($event_id, 'events');
}

function make_event_obj($params, $obj = null) {
    return make_model_object($params, $obj);
}

function event_columns() {
    return array('name', 'created_at', 'updated_at');
}

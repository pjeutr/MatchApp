<?php

function find_users() { 
    $sql =
        "SELECT " .
        "b.id as id, b.name as name, b.last_seen as last_seen, b.group_id as group_id, " .
        "a.name as group_name, b.remarks as remarks, b.keycode as keycode " .
        "FROM users b " .
        "LEFT JOIN groups a ON a.id=b.group_id";
    return find_objects_by_sql($sql);
}

function find_user_by_id($id) {
    $sql =
        "SELECT " .
        "b.id as id, b.name as name, b.last_seen as last_seen, b.group_id as group_id, " .
        "a.name as group_name, b.remarks as remarks, b.keycode as keycode " .
        "FROM users b " .
        "LEFT JOIN groups a ON a.id=b.group_id " .
        "WHERE b.id=:id";   
    return find_object_by_sql($sql, array(':id' => $id));
}

function find_user_by_keycode($keycode) {
    $sql =
        "SELECT " .
        "b.id as id, b.name as name, b.last_seen as last_seen, b.group_id as group_id, " .
        "a.name as group_name, b.remarks as remarks, b.keycode as keycode " .
        "FROM users b " .
        "LEFT JOIN groups a ON a.id=b.group_id " .
        "WHERE b.keycode=:keycode";   
    return find_object_by_sql($sql, array(':keycode' => $keycode));
}

function update_user_last_seen($user_obj) {
    $sql = "UPDATE users SET last_seen = DateTime('now') WHERE id = ".$user_obj->id;
    return update_object_with_sql($sql, 'users');
}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

function update_user_obj($user_obj) {
    return update_object($user_obj, 'users', user_columns());
}

function create_user_obj($user_obj) {
    return create_object($user_obj, 'users', user_columns());
}

function delete_user_obj($man_obj) {
    delete_object_by_id($man_obj->id, 'users');
}

function delete_user_by_id($user_id) {
    delete_object_by_id($user_id, 'users');
}

function make_user_obj($params, $obj = null) {
    return make_model_object($params, $obj);
}

function user_columns() {
    return array('name', 'keycode', 'group_id', 'last_seen', 'remarks');
}

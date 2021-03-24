<?php

function find_settings() {
    return find_objects_by_sql("SELECT * FROM `settings`");
}

function find_setting_by_id($id) {
    $sql =
        "SELECT * " .
        "FROM settings " .
        "WHERE id=:id";
    return find_object_by_sql($sql, array(':id' => $id));
}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

function update_setting_obj($setting_obj) {
    return update_object($setting_obj, 'settings', setting_columns());
}

function create_setting_obj($setting_obj) {
    return create_object($setting_obj, 'settings', setting_columns());
}

function delete_setting_obj($man_obj) {
    delete_object_by_id($man_obj->id, 'settings');
}

function delete_setting_by_id($setting_id) {
    delete_object_by_id($setting_id, 'settings');
}

function make_setting_obj($params, $obj = null) {
    return make_model_object($params, $obj);
}

function setting_columns() {
    return array('name', 'created_at', 'updated_at');
}






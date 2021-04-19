<?php

function find_rules() {
    return find_objects_by_sql("SELECT * FROM `rules`");
}

function find_rule_by_id($id) {
    $sql =
        "SELECT * " .
        "FROM rules " .
        "WHERE id=:id";
    return find_object_by_sql($sql, array(':id' => $id));
}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

function update_rule_obj($rule_obj) {
    return update_object($rule_obj, 'rules', rule_columns());
}

function create_rule_obj($rule_obj) {
    return create_object($rule_obj, 'rules', rule_columns());
}

function delete_rule_obj($man_obj) {
    delete_object_by_id($man_obj->id, 'rules');
}

function delete_rule_by_id($rule_id) {
    delete_object_by_id($rule_id, 'rules');
}

function make_rule_obj($params, $obj = null) {
    return make_model_object($params, $obj);
}

function rule_columns() {
    return array('name');
}






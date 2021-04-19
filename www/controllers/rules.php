<?php

# GET /rules
function rules_index() {
    set('rules', find_rules());
    return html('rules/index.html.php');
}

# GET /rules/:id
function rules_show() {
    $rule = get_rule_or_404();
    set('rule', $rule);
    return html('rules/show.html.php');
}

# GET /rules/:id/edit
function rules_edit() {
    $rule = get_rule_or_404();
    set('rule', $rule);
    return html('rules/edit.html.php');
}

# PUT /rules/:id
function rules_update() {
    $rule_data = rule_data_from_form();
    $rule = get_rule_or_404();
    $rule = make_rule_obj($rule_data, $rule);

    update_rule_obj($rule);
    redirect('rules');
}

# GET /rules/new
function rules_new() {
    $rule_data = make_empty_obj(rule_columns());
    set('rule', make_rule_obj($rule_data));
    //set('authors', find_authors());
    return html('rules/new.html.php');
}

# POST /rules
function rules_create() {
    $rule_data = rule_data_from_form();
    $rule = make_rule_obj($rule_data);

    create_rule_obj($rule);
    redirect('rules');
}

# DELETE /rules/:id
function rules_destroy() {
    delete_rule_by_id(filter_var(params('id'), FILTER_VALIDATE_INT));
    redirect('rules');
}

function get_rule_or_404() {
    $rule = find_rule_by_id(filter_var(params('id'), FILTER_VALIDATE_INT));
    if (is_null($rule)) {
        halt(NOT_FOUND, "This rule doesn't exist.");
    }
    return $rule;
}

function rule_data_from_form() {
    return isset($_POST['rule']) && is_array($_POST['rule']) ? $_POST['rule'] : array();
}

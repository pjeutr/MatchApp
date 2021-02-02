<?php

# GET /groups
function groups_index() {
    set('groups', find_groups());
    set('doors', find_doors());
    return html('groups/index.html.php');
}

# GET /groups/:id
function groups_show() {
    $group = get_group_or_404();
    set('group', $group);
    return html('groups/show.html.php');
}

# GET /groups/:id/edit
function groups_edit() {
    $group = get_group_or_404();
    set('group', $group);
    //set('authors', find_authors());
    return html('groups/edit.html.php');
}

# PUT /groups/:id
function groups_update() {
    $group_data = group_data_from_form();
    $group = get_group_or_404();
    $group = make_group_obj($group_data, $group);

    update_group_obj($group);
    redirect('groups');
}

# GET /groups/new
function groups_new() {
    $group_data = group_data_from_form();
    set('group', make_group_obj($group_data));
    //set('authors', find_authors());
    return html('groups/new.html.php');
}

# POST /groups
function groups_create() {
    $group_data = group_data_from_form();
    $group = make_group_obj($group_data);

    create_group_obj($group);
    redirect('groups');
}

# DELETE /groups/:id
function groups_destroy() {
    delete_group_by_id(filter_var(params('id'), FILTER_VALIDATE_INT));
    redirect('groups');
}

function get_group_or_404() {
    $group = find_group_by_id(filter_var(params('id'), FILTER_VALIDATE_INT));
    if (is_null($group)) {
        halt(NOT_FOUND, "This group doesn't exist.");
    }
    return $group;
}

function group_data_from_form() {
    return isset($_POST['group']) && is_array($_POST['group']) ? $_POST['group'] : array();
}

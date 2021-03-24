<?php

require_once('lib/limonade.php');

function configure() {
    $env = $_SERVER['HTTP_HOST'] == 'library.dev' ? ENV_DEVELOPMENT : ENV_PRODUCTION;
    $dsn = $env == ENV_PRODUCTION ? 'sqlite:db/dev.db' : 'sqlite:db/dev.db';
    $db = new PDO($dsn);
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    option('env', $env);
    option('dsn', $dsn);
    option('db_conn', $db);
    option('debug', true);
}

function after($output) {
    $time = number_format( (float)substr(microtime(), 0, 10) - LIM_START_MICROTIME, 6);
    $output .= "<!-- page rendered in $time sec., on " . date(DATE_RFC822)."-->";
    return $output;
}

function not_found($errno, $errstr, $errfile=null, $errline=null)
{
  $html = '<p>'
        . h($errstr)
        . '"></p>';
  set('title', 'FOUT 404');
  return html($html);
}

function server_error($errno, $errstr, $errfile=null, $errline=null)
{
  $html = '<p>'
        . $errno . "<br>"
        . $errstr . "<br>"
        . $errfile . "<br>"
        . $errline . "<br>"
        . '</p>';
  set('title', 'FOUT 500');
  return html($html);
}

layout('layout/default.html.php');

// main controller
dispatch('/', 'dashboard_page');
dispatch('main', 'main_page');
dispatch('timezones', 'timezone_index');
dispatch('reports', 'report_index');
dispatch('events', 'event_index');

dispatch('dash', 'dashboard_page');
function dashboard_page() {
    return html('dashboard.html.php');
}
dispatch('groups2', 'groups_page');
function groups_page() {
    return html('groups.html.php');
}
//dispatch('info', phpinfo());

dispatch('gpio', 'gpio_page');
function gpio_page() {
    return html('gpio.html.php');
}
// main controller
dispatch_get   ('gpio/:id/:state',  'gpio_state');
dispatch_get   ('gpio_key',  'gpio_key');
dispatch_get   ('door/:id/',      'door_open');

dispatch_get   ('settings',   'settings_index');

//ajax
dispatch_get   ('last_reports',   'last_reports');

// doors controller
dispatch_get   ('doors',          'doors_index');
dispatch_post  ('doors',          'doors_create');
dispatch_get   ('doors/new',      'doors_new');
dispatch_get   ('doors/:id/edit', 'doors_edit');
dispatch_get   ('doors/:id',      'doors_show');
dispatch_put   ('doors/:id',      'doors_update');
dispatch_delete('doors/:id',      'doors_destroy');

// users controller
dispatch_get   ('users',          'users_index');
dispatch_post  ('users',          'users_create');
dispatch_get   ('users/new',      'users_new');
dispatch_get   ('users/:id/edit', 'users_edit');
dispatch_get   ('users/:id',      'users_show');
dispatch_put   ('users/:id',      'users_update');
dispatch_delete('users/:id',      'users_destroy');

// groups controller
dispatch_get   ('groups',          'groups_index');
dispatch_post  ('groups',          'groups_create');
dispatch_get   ('groups/new',      'groups_new');
dispatch_get   ('groups/:id/edit', 'groups_edit');
dispatch_get   ('groups/:id',      'groups_show');
dispatch_put   ('groups/:id',      'groups_update');
dispatch_delete('groups/:id',      'groups_destroy');
run();

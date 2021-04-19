<?php

require_once('lib/limonade.php');

function configure() {
    $env = $_SERVER['HTTP_HOST'] == 'library.dev' ? ENV_DEVELOPMENT : ENV_PRODUCTION;
    $dsn = $env == ENV_PRODUCTION ? 'sqlite:db/dev.db' : 'sqlite:db/dev.db';
    $db = new PDO($dsn);
    //$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    option('env', $env);
    option('dsn', $dsn);
    option('db_conn', $db);
    option('debug', true);
}

function before($route = array())
{
    error_log("before session=".$_SESSION['login']."");
    error_log("l=".request_method()."_".request_uri());
    if(request_method() != "POST") {
      if(isset($_SESSION['login'])) {
        layout('layout/default.html.php');
      } else {
        //$route['options']['authenticate'];
        //flash('errors', $errors);
        error_log("no session");
        echo login_page();
        //echo after(error_notices_render() . login_page());
        //stop_and_exit();
      }
    }
}

//layout('layout/default.html.php');

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

dispatch_get('login', 'login_page');
dispatch_get('logout', 'logout_page');
dispatch_post('login', 'login_page_post');
function login_page() {
  return html('login.html.php');
  //return render('login.html.php', 'splash_layout.php');
}
function login_page_post() {
  //TODO geen sanitize check
  if(check_password($_POST['password'])) {
    $_SESSION['login'] = 'my_value';
    redirect_to('http://'.$_SERVER['HTTP_HOST'].'/');
  } else {
    flash("error", "The password was wrong");
    set('message', "The password was wrong");
    return render('login.html.php', null);
  //return render('login.html.php', 'splash_layout.php');
  }
}
function logout_page() {
  //unset($_SESSION['login']);
  $_SESSION['login'] = null;
  return render('login.html.php', null);
}



// main controller
dispatch('/', 'dashboard_page');
dispatch('dash', 'dashboard_page');
function dashboard_page() {
  return html('dashboard.html.php');
}
dispatch('reports', 'report_index');
dispatch('events', 'event_index');

//TODO remove testpages
//dispatch('info', phpinfo());
dispatch('main', 'main_page');
dispatch('gpio', 'gpio_page');
function gpio_page() {
    return html('gpio.html.php');
}

// main controller
dispatch_get   ('gpio/:id/:state',  'gpio_state');
dispatch_get   ('gpio_key',  'gpio_key');
dispatch_get   ('door/:id/',      'door_open');

dispatch_get   ('settings',   'settings_index');
dispatch_put   ('settings/:id', 'settings_update');

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

// access controller
dispatch_get   ('rules',          'rules_index');
dispatch_post  ('rules',          'rules_create');
dispatch_get   ('rules/new',      'rules_new');
dispatch_get   ('rules/:id/edit', 'rules_edit');
dispatch_get   ('rules/:id',      'rules_show');
dispatch_put   ('rules/:id',      'rules_update');
dispatch_delete('rules/:id',      'rules_destroy');

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

// timezones controller
dispatch_get   ('timezones',          'timezones_index');
dispatch_post  ('timezones',          'timezones_create');
dispatch_get   ('timezones/new',      'timezones_new');
dispatch_get   ('timezones/:id/edit', 'timezones_edit');
dispatch_get   ('timezones/:id',      'timezones_show');
dispatch_put   ('timezones/:id',      'timezones_update');
dispatch_delete('timezones/:id',      'timezones_destroy');
run();

<?php
spl_autoload_register(function($class) {
    include $class . '.php';
});
define('SESS_LIFETIME', 2592000);

session_start();
ini_set('session.cookie_lifetime', SESS_LIFETIME);
ini_set('session.gc_maxlifetime', SESS_LIFETIME);
error_reporting(E_ALL ^ E_NOTICE);

$router = new router();
$router->startRouting();
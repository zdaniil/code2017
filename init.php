<?php
use Classes\Registry;
use Classes\Router;
use Classes\Db;
use Classes\ViewModel;

/*** registry function ***/
spl_autoload_register(function ($class) {
    $file = $class . '.php';
    if (file_exists($file) == false) {
        return false;
    }

    include $file;
});

/*** a new registry object ***/
$registry = new Registry();

/*** create the database registry object ***/
//$registry->db = new Db();
$registry->view = new ViewModel($registry);

/*** load the Router ***/
$registry->Router = new Router($registry);
/*** set the path to the controllers directory ***/
$registry->Router->setPath(__SITE_PATH . '/Controllers');
$registry->Router->load();
?>
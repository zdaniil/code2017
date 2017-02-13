<?php

/*** error reporting on ***/
error_reporting(E_ALL);//отчет об ошибках

/*** define the site path constant ***/
$site_path = realpath(dirname(__FILE__));//$site_path-путь, realpath- возвр. абсолютный кананонизированый путь. возвращаем имя родительского каталога из указаного пути
define('__SITE_PATH', $site_path); опр. константы

/*** include the init.php file ***/
include 'init.php';
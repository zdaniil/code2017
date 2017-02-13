<?php
/**
 * Routes format $routes['class'] = '[path/to/]action'
 *
 * default route $routes['default'] = 'class/action';
 */
$routes['login'] = 'auth/login';
$routes['registration'] = 'auth/registration';
$routes['logout'] = 'user/logout';
$routes['parallax'] = 'user/parallax';
$routes['default'] = 'user/show';

return $routes;


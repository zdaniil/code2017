<?php

class router {
    private $routes = array();
    private $request = '';
    function __construct(){
        $this->routes = require 'routes.php';
        $rawQuery = isset($_GET['query'])?$_GET['query']:'';
        $this->request = filter_var($rawQuery, FILTER_VALIDATE_REGEXP,
                         array("options"=>array("regexp"=>"/^([a-z][a-z0-9\/]*)?$/")));
        $this->request = (!$this->request)?'':$this->request;
    }
    public function startRouting(){

        $cases = '';
        foreach ($this->routes as $route => $classAction){
            $actCls = explode('/', $classAction);

            if ($route == 'default'){
                $cases .= "case '':
                    \$action ='" . end($actCls) . "';
                    \$class ='" . reset($actCls) . "'; break;";
            } else {
                $cases .= "case '" . $route . "':
                    \$action ='" . end($actCls) . "';
                    \$class ='" . reset($actCls) . "'; break;";
            }
        }
        $ready_eval_str = "switch(\$this->request){".$cases."default:
                            header('HTTP/1.1 404 Not Found');
                            die('Page not found!');}
                            return array(\$action, \$class);";
        $cr_route = eval($ready_eval_str);
        $this->toController($cr_route);
    }
    public function toController(array $route){
        $class = end($route);
        $action = reset($route);
        $controller = new $class($this);
        $controller->$action();
    }
}
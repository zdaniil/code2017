<?php if ( ! defined('SESS_LIFETIME')) exit('No direct script access allowed.');

/**
 * Class controller
 */
class controller {

    protected $config;
    protected $db;
    protected $router;

    function __construct(router $routerInstance) {
        $this->router = $routerInstance;
        $this->config = new config();
        $this->db = new model($this->config->get_item('connect_options'));
    }

    /**
     * @param string $target
     * @return string
     */
    public function makeLink($target = ''){
        $prefix = substr(dirname(@$_SERVER['SCRIPT_FILENAME']), strlen(@$_SERVER['DOCUMENT_ROOT']));
        return $prefix.'/'.$target;
    }

    /**
     * @param $view
     * @param array $data
     */
    public function loadView($view = '', $data = array()){
        $path = 'view/'. $view .'.php';
        if (file_exists($path)) {
            ob_start();
            include($path);
            ob_end_flush();
        } else {
            die('View '. $path .' not found.');
        }
    }

    public function loadLibrary($libname = ''){
        $path = 'libs/'. $libname .'.php';
        if (file_exists($path)) {
            include($path);
        } else {
            die('Lib-file '. $path .' is not exist.');
        }
        $this->$libname = new $libname();
    }
}

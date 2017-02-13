<?php if ( ! defined('SESS_LIFETIME')) exit('No direct script access allowed.');

/**
 * Class user
 */
class user extends controller{
    function __construct(router $routerInstance){
        parent::__construct($routerInstance);
        if ($_SESSION['user_logged_in'] == false){
            header("Location: ".$this->makeLink('login'));
            exit;
        }
    }
    public function logout(){
        session_destroy();
        header("Location: ".$this->makeLink('login'));
        exit;
    }
    public function show(){
        $data['title'] = 'User page';
        $res = $this->db->get_user('login', $_SESSION['user_login']);
        if (!$res){
            die('Database error! '. $this->db->show_error());
        }

        $data['real_name'] = $res->real_name;
        $data['email'] = $res->email;
        $data['country'] = $this->config->get_item('countries')[$res->country];
        $this->loadView('showuser', $data);
    }
    public function parallax(){
        $data['title'] = 'Parallax page';
        $this->loadView('parallax', $data);
    }
}

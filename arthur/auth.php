<?php if ( ! defined('SESS_LIFETIME')) exit('No direct script access allowed.');

/**
 * Class auth
 */
class auth extends controller {
    function __construct(router $routerInstance){
        parent::__construct($routerInstance);
        if (!empty($_SESSION['user_logged_in'])){
            header("Location: ".$this->makeLink());
            exit;
        }
    }

    public function login(){
        $data['title'] = 'Login page';
        $error = '';
        $success = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $login_email = trim($_POST['login_email']);
            $pass = trim($_POST['pass']);
            if (empty($login_email)) {
                $error['login_email'] = $this->config->get_item('messages')['empty_field'];
            } elseif(!preg_match('/^\w[-._\w]*\w@\w[-._\w]*\w\.\w{2,3}$/', $login_email) &&
                      !preg_match('/^[\w\s_+]{1,40}$/', $login_email)){
                $error['login_email'] = $this->config->get_item('messages')['incorrect_email_login'];
            } else {
                $success['login_email'] = true;
            }
            if (empty($pass)) {
                $error['pass'] = $this->config->get_item('messages')['empty_field'];
            } elseif(!preg_match('/^[\w()\s_-]+$/', $pass)){
                $error['pass'] = $this->config->get_item('messages')['incorrect_pass'];
            } else {
                $success['pass'] = true;
            }
            if (empty($error)){
                if (strripos($login_email, "@") !== FALSE){
                    $res = $this->db->get_user('email', $login_email, sha1(md5($pass).$this->config->get_item('encryption_key')));
                } else {
                    $res = $this->db->get_user('login', $login_email, sha1(md5($pass).$this->config->get_item('encryption_key')));
                }
                if (empty($res)){
                    $error['auth_error'] = $this->config->get_item('messages')['auth_error'];
                    $success['pass'] = '';
                    $success['login_email'] = '';
                } else {
                    $_SESSION['user_logged_in'] = true;
                    $_SESSION['user_login'] = $res->login;
                    header("Location: ".$this->makeLink());
                    exit;
                }
            }
            $data['login_email'] = $login_email;
            $data['pass'] = $pass;
        }
        $data['error'] = $error;
        $data['success'] = $success;
        $this->loadView('login', $data);
    }

    public function registration(){
        $data['title'] = 'Registration page';
        $error = '';
        $success = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $login = trim($_POST['login']);
            $pass = trim($_POST['pass']);
            $email = trim($_POST['email']);
            $real_name = trim($_POST['real_name']);
            $birth_date = $_POST['birth_date'];
            $country = $_POST['country'];
            $checkbox = (int)$_POST['checkbox'];

            if (empty($login)) {
                $error['login'] = $this->config->get_item('messages')['empty_field'];
            } elseif(!preg_match('/^[\w\s_+]{1,40}$/', $login)){
                $error['login'] = $this->config->get_item('messages')['incorrect_login'];
            } else {
                $success['login'] = true;
            }
            if (empty($pass)) {
                $error['pass'] = $this->config->get_item('messages')['empty_field'];
            } elseif(!preg_match('/^[\w()\s_-]+$/', $pass)){
                $error['pass'] = $this->config->get_item('messages')['incorrect_pass'];
            } else {
                $success['pass'] = true;
            }
            if (empty($email)) {
                $error['email'] = $this->config->get_item('messages')['empty_field'];
            } elseif(!preg_match('/^\w[-._\w]*\w@\w[-._\w]*\w\.\w{2,3}$/', $email)){
                $error['email'] = $this->config->get_item('messages')['incorrect_email'];
            } else {
                $success['email'] = true;
            }
            if (empty($real_name)) {
                $error['real_name'] = $this->config->get_item('messages')['empty_field'];
            } elseif(!preg_match('/^[\w\s_+]{1,80}$/', $real_name)){
                $error['real_name'] = $this->config->get_item('messages')['incorrect_real_name'];
            } else {
                $success['real_name'] = true;
            }
            if (empty($birth_date)) {
                $error['birth_date'] = $this->config->get_item('messages')['empty_field'];
            } elseif(!preg_match('/^[0-9]{4}\-[0-3]?[0-9]\-[0-3]?[0-9]$/', $birth_date)){var_dump($birth_date);
                $error['birth_date'] = $this->config->get_item('messages')['incorrect_birth_date'];
            } else {
                $success['birth_date'] = true;
            }
            if ($country === '') {
                $error['country'] = $this->config->get_item('messages')['empty_field'];
            } elseif(!is_numeric($country) || !array_key_exists($country, $this->config->get_item('countries'))){
                $error['country'] = $this->config->get_item('messages')['incorrect_country'];
            } else {
                $success['country'] = true;
            }
            if (empty($checkbox)) {
                $error['checkbox'] = $this->config->get_item('messages')['empty_field'];
            } else {
                $success['checkbox'] = true;
            }
            if (empty($error)){

                $res = $this->db->get_user('login', $login);
                if (!empty($res)){
                    $error['reg_error'] = $this->config->get_item('messages')['reg_error'];
                } else {
                    $user_data['login'] = $login;
                    $user_data['pass'] = sha1(md5($pass).$this->config->get_item('encryption_key'));
                    $user_data['email'] = $email;
                    $user_data['real_name'] = $real_name;
                    $user_data['birth_date'] = $birth_date;
                    $user_data['country'] = $country;
                    if (!$this->db->add_user($user_data)){
                        die('Database error! '. $this->db->show_error());
                    }
                    $_SESSION['user_logged_in'] = true;
                    $_SESSION['user_login'] = $user_data['login'];
                    header("Location: ".$this->makeLink());
                    exit;
                }
            }
            $data['login'] = $login;
            $data['pass'] = $pass;
            $data['email'] = $email;
            $data['real_name'] = $real_name;
            $data['birth_date'] = $birth_date;
            $data['country'] = (int)$country;
        }
        $data['error'] = $error;
        $data['success'] = $success;
        $this->loadView('registration', $data);
    }
}
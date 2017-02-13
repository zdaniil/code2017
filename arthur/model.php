<?php if ( ! defined('SESS_LIFETIME')) exit('No direct script access allowed.');

/**
 * Class model
 */
class model{

    protected $mysqli;

    function __construct($options){
        $this->mysqli = new mysqli($options['host'], $options['user'], $options['password'], $options['database']);

        if (mysqli_connect_errno()) {
            printf("Database error. Code: %s\n", mysqli_connect_error());
            exit;
        }
    }
    function __destruct(){
        $this->mysqli->close();
    }

    /**
     * @param $field
     * @param $value
     * @param string $pass
     * @return bool|object|stdClass
     */
    public function get_user($field, $value, $pass = ''){
        $and = '';
        if ($pass) {
            $and = "AND password = '$pass'";
        }
        if ($result = $this->mysqli->query("SELECT login, real_name, email, country FROM users WHERE $field='$value' $and")) {
            return $result->fetch_object();
        }
        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    public function add_user($data){
        if ($result = $this->mysqli->query("INSERT INTO users (login, password, email, real_name, birth_date, country)
                          VALUES ('". $this->mysqli->escape_string($data['login']) ."',
                                  '". $this->mysqli->escape_string($data['pass']) ."',
                                  '". $this->mysqli->escape_string($data['email']) ."',
                                  '". $this->mysqli->escape_string($data['real_name']) ."',
                                  '". $this->mysqli->escape_string($data['birth_date']) ."',
                                  '". $this->mysqli->escape_string($data['country']) ."'
                                  )")) {

            return true;
        }
        return false;
    }
    public function show_error(){
        return $this->mysqli->error;
    }
}
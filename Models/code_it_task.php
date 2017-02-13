<?php

namespace Models;

use Classes\Db;
use Classes\DbError;

class code_it_task extends Db
{
    private $table = 'users';

    public function add($data)
    {
        $stmt = Db::$connection->prepare("INSERT INTO $this->table(email, login, real_name, password, date_of_birth, country, date_of_registration) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssisi', $data['email'], $data['login'], $data['real_name'], $data['date_of_birth'], $data['country'], $data['date_of_registration']);
        $stmt->execute();

        return $stmt->insert_id;
    }
}

class user extends controller
{
    function __construct(router $routerInstance)
    {
        parent::__construct($routerInstance);
        if ($_SESSION['user_logged_in'] == false) {
            header("Location: " . $this->makeLink('login'));
            exit;
        }
    }
}

?>
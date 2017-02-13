<?php

namespace Classes;

/**
 * Class Db
 * @package Classes
 */
class Db
{
    static $connection;

    public function __construct()
    {
        if (empty(self::$connection)) {
            self::$connection = new \mysqli('127.0.0.1', 'root', '', 'code_it_task');
            if (self::$connection->connect_errno) {

                $error = new DbError(self::$connection->connect_error, self::$connection->connect_errno);
                throw $error;
            }
        }
    }
}

class DbError extends \Exception
{

    function __construct($message = 'Data base error', $code = null, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
?>
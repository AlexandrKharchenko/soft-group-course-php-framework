<?php


namespace Core\Fm;


use PDO;
use PDOException;

class Db
{
    private $pdo;
    private static $instance;
    protected $is_connected = false;
    public $fetch_mode;

    public static function getInstance() {
        if (!isset(self::$instance))
        {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance;
    }

    public function connect(){

        $dsn = 'mysql:dbname='.Config::get('db' , 'db_name').';host='.Config::get('db' , 'db_host').'';
        echo $dsn;
        try {
            # Read settings from INI file, set UTF8
            $this->pdo = new PDO($dsn, Config::get('db' , 'db_user') , Config::get('db' , 'db_password'), array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->is_connected = true;
            $this->fetch_mode = PDO::FETCH_ASSOC;
            return $this->pdo;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function CloseConnection() {
        $this->pdo = null;
        return true;
    }

    public function __destruct() {
        $this->CloseConnection();
    }
}
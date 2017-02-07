<?php

namespace Core\App;

use Core\Fm\Db;

class Model extends Db
{
    private $dbh;
    public $pdo;

    public function __construct()
    {
        $this->dbh = Db::getInstance();
    }


    public function select()
    {
        if ( !$this->dbh->is_connected ) {
            $this->pdo = $this->dbh->connect();

        }

        $query = $this->pdo->prepare('SELECT * FROM test');
        $query->execute();
        $data = $query->fetchAll($this->dbh->fetch_mode);

        

    }
}
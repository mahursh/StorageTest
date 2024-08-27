<?php

namespace Library;

use Exception;
use PDO;

class Database
{
    private $localhost = DB_HOST;
    private $username = DB_USER;
    private $password = DB_PASSWORD;
    private $db = DB_NAME;
    private $dbh;
    private $stmt;
    private $error;
    public function __construct()
    {
        try {

            $dns = "mysql:host=" . $this->localhost . ";dbname=" . $this->db . ";charset=utf8";
            $this->dbh = new PDO($dns, $this->username, $this->password);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }
    public function bind($param, $value)
    {
        $this->stmt->bindParam($param, $value);
    }

    public function execute()
    {
        $this->stmt->execute();
    }

    public function fetchAll()
    {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    public function fetch()
    {
        $this->execute();
        return $this->stmt->fetch();
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }
}
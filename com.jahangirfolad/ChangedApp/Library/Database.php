<?php

namespace Library;

use Exception;
use PDO;

class Database
{
    private $localhost = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "jf";
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
//    public function bind($param, $value)
//    {
//        $this->stmt->bindParam($param, $value);
//    }
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value): $type = PDO::PARAM_INT; break;
                case is_bool($value): $type = PDO::PARAM_BOOL; break;
                case is_null($value): $type = PDO::PARAM_NULL; break;
                default: $type = PDO::PARAM_STR;
            }
        }

        if ($type === PDO::PARAM_STR && is_object($value)) {
            $value = json_encode($value); // Convert object to string if necessary
        }

        $this->stmt->bindParam($param, $value, $type); // Corrected property name
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

    public function fetchAllColumn($fetchStyle = PDO::FETCH_OBJ, $columnIndex = 0)
    {
        if ($fetchStyle === PDO::FETCH_COLUMN) {
            return $this->stmt->fetchAll($fetchStyle, $columnIndex);
        } else {
            return $this->stmt->fetchAll($fetchStyle);
        }
    }

    public function getLastQuery()
    {
        return $this->stmt->queryString;
    }

    public function getBoundParams()
    {
        return $this->stmt->debugDumpParams(); // For debugging purposes only; might need custom implementation
    }
}
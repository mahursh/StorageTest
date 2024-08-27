<?php


use Library\Database;

class ProductUnitModel
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();

    }

    public function save($name)
    {
        $this->db->query("INSERT INTO product_unit_tbl (name) VALUES (:name)");
        $this->db->bind(":name", $name);
        $this->db->execute();
        return $this->db->lastInsertId();
    }

    public function update($id, $name)
    {
        $this->db->query("UPDATE product_unit_tbl SET name = :name WHERE id = :id");
        $this->db->bind(":name", $name);
        $this->db->bind(":id", $id);
        $this->db->execute();
    }

    public function findById($id)
    {
        $this->db->query("SELECT * FROM product_unit_tbl WHERE id = :id");
        $this->db->bind(":id", $id);
        $this->db->fetch();
    }

    public function findAll()
    {
        $this->db->query("SELECT * FROM product_unit_tbl");
        return $this->db->fetchAll();

    }


}
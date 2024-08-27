<?php

namespace Model;

use Library\Database;

class ProductModel
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function save($category , $productGroupId ){
        $this->db->query("INSERT INTO product_tbl (category, product_group_id) VALUES (:category, :productGroupId)");
        $this->db->bind(":category", $category);
        $this->db->bind(":productGroupId", $productGroupId);
        $this->db->execute();
        return $this->db->lastInsertId();

    }

    public function update($id , $category , $productGroupId ){
        $this->db->query("UPDATE product_tbl SET name = :name,  product_group_id = :productGroupId WHERE id = :id");
        $this->db->bind(":name", $category);
        $this->db->bind(":productGroupId", $productGroupId);
        $this->db->bind(":id", $id);
        $this->db->execute();
    }

    public function findById($id){
        $this->db->query("SELECT * FROM product_tbl WHERE id = :id");
        $this->db->bind(":id", $id);
        return $this->db->fetch();
    }

}
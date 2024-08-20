<?php

namespace Repository;


use Entity\ProductUnit;

use PDO;

class ProductUnitRepository
{

    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(ProductUnit $unit)
    {
        $sql = "INSERT INTO product_unit_tbl (name) VALUES (:name)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':name' => $unit->getName()]);
        $unit->setId($this->pdo->lastInsertId());
    }

    public function update(ProductUnit $unit)
    {
        $sql = "UPDATE product_unit_tbl SET name = :name WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':name' => $unit->getName(), ':id' => $unit->getId()]);
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM product_unit_tbl WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $unit = new ProductUnit($data['name']);
            $unit->setId($data['id']);
            return $unit;
        }

        return null;
    }

    public function findAll()
    {
        $sql = "SELECT * FROM product_unit_tbl";
        $stmt = $this->pdo->query($sql);
        $units = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = [];
        foreach ($units as $data) {
            $unit = new ProductUnit($data['name']);
            $unit->setId($data['id']);
            $result[] = $unit;
        }

        return $result;
    }
}
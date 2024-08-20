<?php

namespace Repository;

use Product;

class ProductRepository
{


    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(Product $product)
    {
        $sql = "INSERT INTO product_tbl (name, unit_id, product_group_id) VALUES (:name, :unitId, :productGroupId)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $product->getName(),
            ':unitId' => $product->getUnit() ? $product->getUnit()->getId() : null,
            ':productGroupId' => $product->getProductGroup() ? $product->getProductGroup()->getId() : null
        ]);
        $product->setId($this->pdo->lastInsertId());
    }

    public function update(Product $product)
    {
        $sql = "UPDATE product_tbl SET name = :name, unit_id = :unitId, product_group_id = :productGroupId WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $product->getName(),
            ':unitId' => $product->getUnit() ? $product->getUnit()->getId() : null,
            ':productGroupId' => $product->getProductGroup() ? $product->getProductGroup()->getId() : null,
            ':id' => $product->getId()
        ]);
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM product_tbl WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $unit = ProductUnit::findById($this->pdo, $data['unit_id']);
            $productGroup = ProductGroup::findById($this->pdo, $data['product_group_id']);
            $product = new Product($data['name'], $unit, $productGroup);
            $product->setId($data['id']);
            return $product;
        }

        return null;
    }
}
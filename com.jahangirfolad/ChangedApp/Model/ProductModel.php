<?php

namespace Model;

use Library\Database;
use PDO;

class ProductModel
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function save($category, $productGroupId)
    {
        $this->db->query("INSERT INTO product_tbl (category, product_group_id) VALUES (:category, :productGroupId)");
        $this->db->bind(":category", $category);
        $this->db->bind(":productGroupId", $productGroupId);
        $this->db->execute();
        return $this->db->lastInsertId();

    }

    public function update($id, $category, $productGroupId)
    {
        $this->db->query("UPDATE product_tbl SET category = :category,  product_group_id = :productGroupId WHERE id = :id");
        $this->db->bind(":category", $category);
        $this->db->bind(":productGroupId", $productGroupId);
        $this->db->bind(":id", $id);
        $this->db->execute();
    }

    public function findById($id)
    {
        $this->db->query("SELECT * FROM product_tbl WHERE id = :id");
        $this->db->bind(":id", $id);
        return $this->db->fetch();
    }

    public function findAll()
    {
        $this->db->query("SELECT * FROM product_tbl");
        return $this->db->fetchAll();
    }

    public function getAllChildGroupNames($productId) {
        // First, fetch the product to get its associated product_group_id
        $this->db->query("SELECT product_group_id FROM product_tbl WHERE id = :id");
        $this->db->bind(":id", $productId);
        $product = $this->db->fetch();

        if ($product && $product->product_group_id) {
            // Now, fetch the child groups of the associated product group
            $this->db->query("SELECT child_group_list FROM product_group_tbl WHERE id = :id");
            $this->db->bind(":id", $product->product_group_id);
            $groupData = $this->db->fetch();

            if ($groupData && $groupData->child_group_list) {
                $groupIds = json_decode($groupData->child_group_list, true);

                if (!empty($groupIds)) {
                    // Create placeholders for each child group ID
                    $placeholders = implode(',', array_fill(0, count($groupIds), '?'));
                    $query = "SELECT name FROM product_group_tbl WHERE id IN ($placeholders)";
                    $this->db->query($query);

                    // Bind each group ID
                    foreach ($groupIds as $index => $id) {
                        $this->db->bind($index + 1, $id);  // 1-based index for positional parameters
                    }

                    $this->db->execute();
                    return $this->db->fetchAll(PDO::FETCH_COLUMN); // Return only the names
                }
            }
        }
        return [];
    }


}
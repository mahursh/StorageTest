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
//                    return $this->db->fetchAll(PDO::FETCH_COLUMN); // Return only the names
                    return $this->db->fetchAll();
                }
            }
        }
        return [];
    }


//    public function findProductByProductGroup(...$groupNames)
//    {
//        // Ensure there's at least one and at most four group names provided
//        if (count($groupNames) < 1 || count($groupNames) > 4) {
//            throw new InvalidArgumentException('You must provide between 1 and 4 product group names.');
//        }
//
//        // Create a string of placeholders for the number of group names
//        $placeholders = implode(',', array_fill(0, count($groupNames), '?'));
//
//        // SQL query to find products by product group names
//        $query = "
//        SELECT p.*
//        FROM product_tbl p
//        JOIN product_group_tbl g ON p.product_group_id = g.id
//        WHERE g.name IN ($placeholders)
//    ";
//
//        $this->db->query($query);
//
//        // Bind each group name to the placeholders
//        foreach ($groupNames as $index => $name) {
//            $this->db->bind($index + 1, $name);  // Bind using 1-based index for positional parameters
//        }
//
//        return $this->db->fetchAll();
//    }
//====================================================

    public function findProductByProductGroup(...$groupNames)
    {
        if (count($groupNames) < 1 || count($groupNames) > 4) {
            throw new InvalidArgumentException('You must provide between 1 and 4 product group names.');
        }

        $query = "
        SELECT g1.id
        FROM product_group_tbl g1
        WHERE g1.name = :name0
    ";

        for ($i = 1; $i < count($groupNames); $i++) {
            $alias = "g" . ($i + 1);
            $query .= "
            AND EXISTS (
                SELECT 1
                FROM product_group_tbl $alias
                WHERE $alias.name = :name$i
                AND JSON_CONTAINS(g1.child_group_list, JSON_QUOTE(CAST($alias.id AS CHAR)))
            )
        ";
        }

        $this->db->query($query);

        foreach ($groupNames as $index => $name) {
            $this->db->bind(":name$index", $name);
        }

        // Debugging: Output the last query and bound parameters
        echo "Debug Query:\n" . $this->db->getLastQuery() . "\n";
        echo "Bound Parameters:\n" . print_r($this->db->getBoundParams(), true) . "\n";

        $groupIds = $this->db->fetchAllColumn(PDO::FETCH_COLUMN, 0);
        if (empty($groupIds)) {
            echo "No group IDs found.\n";
            return [];
        }

        foreach ($groupIds as $groupId) {
            echo $groupId . "\n";
        }

        $placeholders = implode(',', array_fill(0, count($groupIds), '?'));

        $query = "
        SELECT *
        FROM product_tbl
        WHERE product_group_id IN ($placeholders)
    ";

        $this->db->query($query);

        foreach ($groupIds as $index => $id) {
            $this->db->bind($index + 1, $id);
        }

        // Debugging: Output the last query and bound parameters
        echo "Debug Query:\n" . $this->db->getLastQuery() . "\n";
        echo "Bound Parameters:\n" . print_r($this->db->getBoundParams(), true) . "\n";

        return $this->db->fetchAll();
    }

}
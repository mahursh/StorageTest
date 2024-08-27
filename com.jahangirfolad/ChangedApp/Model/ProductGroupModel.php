<?php

use Library\Database;

class ProductGroupModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function save($name, $parentGroupId = null)
    {
        $this->db->query("INSERT INTO product_group_tbl (name, parent_group_id) VALUES (:name, :parentGroupId)");
        $this->db->bind(":name", $name);
        $this->db->bind(":parentGroupId", $parentGroupId);
        $this->db->execute();
        return $this->db->lastInsertId();

    }

    public function edit($id, $name, $parentGroupId = null){
        $this->db->query("UPDATE product_group_tbl SET name = :name, parent_group_id = :parentGroupId WHERE id = :id");
        $this->db->bind(":name", $name);
        $this->db->bind(":parentGroupId", $parentGroupId);
        $this->db->bind(":id", $id);
        $this->db->execute();
    }

    public function findById($id){
        $this->db->query("SELECT * FROM product_group_tbl WHERE id = :id");
        $this->db->bind(":id", $id);
        return $this->db->fetch();
    }

    public function findAllChildrenByParentId($parentId){
        $this->db->query("SELECT * FROM product_group_tbl WHERE parent_group_id = :parentId");
        $this->db->bind(":parentId", $parentId);
        return $this->db->fetchAll();

    }

    public function findParentByChildGroupId($childGroupId) {
        $this->db->query("SELECT * FROM product_group_tbl WHERE id = :childGroupId");
        $this->db->bind(":childGroupId", $childGroupId);
        $data = $this->db->fetch();

        if ($data && $data->parent_group_id) {
            return $this->findById($data->parent_group_id);
        }
        return null;
    }

//    public function fetchChildGroups($parentId) {
//        $this->db->query("SELECT child_group_list FROM product_group_tbl WHERE id = :id");
//        $this->db->bind(":id", $parentId);
//        $data = $this->db->fetch();
//
//        if ($data && $data->child_group_list) {
//            $groupIds = json_decode($data->child_group_list, true);
//            if (!empty($groupIds)) {
//                $placeholders = rtrim(str_repeat('?,', count($groupIds)), ',');
//                $this->db->query("SELECT * FROM product_group_tbl WHERE id IN ($placeholders)");
//                $this->db->execute($groupIds);
//                return $this->db->fetchAll();
//            }
//        }
//        return [];
//    }



    public function fetchChildGroups($parentId) {
        $this->db->query("SELECT child_group_list FROM product_group_tbl WHERE id = :id");
        $this->db->bind(":id", $parentId);
        $data = $this->db->fetch();

        if ($data && $data->child_group_list) {
            $groupIds = json_decode($data->child_group_list, true);
            if (!empty($groupIds)) {
                // Create a string of placeholders for the number of group IDs
                $placeholders = implode(',', array_fill(0, count($groupIds), '?'));
                $query = "SELECT * FROM product_group_tbl WHERE id IN ($placeholders)";
                $this->db->query($query);

                // Manually bind each group ID to avoid issues
                foreach ($groupIds as $index => $id) {
                    $this->db->bind($index + 1, $id);  // Bind using 1-based index for positional parameters
                }

                $this->db->execute(); // Execute without passing parameters directly
                return $this->db->fetchAll();
            }
        }
        return [];
    }


    public function addChildGroup($parentId, $name) {
        $childGroupId = $this->save($name, $parentId);

        $this->db->query("SELECT child_group_list FROM product_group_tbl WHERE id = :id");
        $this->db->bind(":id", $parentId);
        $data = $this->db->fetch();

        $currentList = $data && $data->child_group_list ? json_decode($data->child_group_list, true) : [];
        $currentList[] = $childGroupId;

        $this->db->query("UPDATE product_group_tbl SET child_group_list = :childGroupList WHERE id = :id");
        $this->db->bind(":childGroupList", json_encode($currentList));
        $this->db->bind(":id", $parentId);
        $this->db->execute();
    }



}
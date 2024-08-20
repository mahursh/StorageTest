<?php

namespace Repository;

class ProductGroupRepository
{

    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(\ProductGroup $productGroup)
    {
        $sql = "INSERT INTO product_group_tbl (name, parent_group_id) VALUES (:name, :parentGroup)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'name' => $productGroup->getName(),
            'parentGroup' => $productGroup->getParentGroup() ? $productGroup->getParentGroup()->getId() : null,
        ]);

        $productGroup->setId($this->pdo->lastInsertId());
    }

    public function update(\ProductGroup $productGroup)
    {
        $sql = "UPDATE product_group_tbl SET name = :name, parent_group_id = :parentGroup WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $productGroup->getName(),
            ':parentGroup' => $productGroup->getParentGroup() ? $productGroup->getParentGroup()->getId() : null,
            ':id' => $productGroup->getId(),
        ]);
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM product_group_tbl WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $group = new ProductGroup($data['name']);
            $group->setId($data['id']);
            $group->setParentGroup($this->findById($data['parent_group_id']));
            return $group;
        }
        return null;
    }

    public function findAllChildrenByParentId($parentId)
    {
        $sql = "SELECT * FROM product_group_tbl WHERE parent_group_id = :parentId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['parentId' => $parentId]);
        $children = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $childGroups = [];
        foreach ($children as $childData) {
            $childGroup = new ProductGroup($childData['name']);
            $childGroup->setId($childData['id']);
            $childGroup->setParentGroup($this->findById($parentId));
            $childGroups[] = $childGroup;
        }

        return $childGroups;
    }

    public function findParentByChildGroupId($childGroupId)
    {
        $sql = "SELECT * FROM product_group_tbl WHERE id = :childGroupId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':childGroupId' => $childGroupId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data && $data['parent_group_id']) {
            return $this->findById($data['parent_group_id']);
        }
        return null;
    }

    public function fetchChildGroups(\ProductGroup $productGroup)
    {
        $sql = "SELECT child_group_list FROM product_group_tbl WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $productGroup->getId()]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data && $data['child_group_list']) {
            $groupIds = json_decode($data['child_group_list'], true);
            $childGroups = [];

            if (!empty($groupIds)) {
                $placeholders = rtrim(str_repeat('?,', count($groupIds)), ',');
                $sql = "SELECT * FROM product_group_tbl WHERE id IN ($placeholders)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($groupIds);
                $childGroupsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($childGroupsData as $childGroupData) {
                    $childGroup = new ProductGroup($childGroupData['name']);
                    $childGroup->setId($childGroupData['id']);
                    $childGroup->setParentGroup($productGroup);
                    $childGroups[] = $childGroup;
                }
            }  $productGroup->setChildGroupList($childGroups);
        }
    }

    public function addChildGroup(\ProductGroup $parentGroup, \ProductGroup $childGroup)
    {
        $childGroup->setParentGroup($parentGroup);
        $this->save($childGroup);

        $sql = "SELECT child_group_list FROM product_group_tbl WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $parentGroup->getId()]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        $currentList = $data && $data['child_group_list'] ? json_decode($data['child_group_list'], true) : [];
        $currentList[] = $childGroup->getId();

        $sql = "UPDATE product_group_tbl SET child_group_list = :childGroupList WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'childGroupList' => json_encode($currentList),
            'id' => $parentGroup->getId(),
        ]);
    }
}
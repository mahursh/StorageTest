<?php

namespace Controller;

use ProductGroup;
use Service\ProductGroupService;

class ProductGroupController
{


    private $service;


    public function __construct(ProductGroupService $service){
        $this->service = $service;
    }



    public function createProductGroup($name , $parentGroupId = null){
        $parentGroup = $parentGroupId ? $this->service->getProductGroupById($parentGroupId) : null;
        $productGroup = new ProductGroup($name, $parentGroup);
        $this->service->saveProductGroup($productGroup);

        return $productGroup;
    }

    public function updateProductGroup($id, $name, $parentGroupId = null)
    {
        $productGroup = $this->service->getProductGroupById($id);
        if ($productGroup) {
            $parentGroup = $parentGroupId ? $this->service->getProductGroupById($parentGroupId) : null;
            $productGroup->setName($name);
            $productGroup->setParentGroup($parentGroup);
            $this->service->updateProductGroup($productGroup);
        }

        return $productGroup;
    }

    public function getProductGroup($id)
    {
        return $this->service->getProductGroupById($id);
    }

    public function getChildren($parentId)
    {
        return $this->service->getChildrenByParentId($parentId);
    }

    public function getParent($childGroupId)
    {
        return $this->service->getParentByChildGroupId($childGroupId);
    }

    public function fetchChildGroups($groupId)
    {
        $productGroup = $this->service->getProductGroupById($groupId);
        if ($productGroup) {
            $this->service->fetchChildGroups($productGroup);
        }
        return $productGroup->getChildGroupList();
    }

    public function addChildGroup($parentGroupId, $childGroupName)
    {
        $parentGroup = $this->service->getProductGroupById($parentGroupId);
        if ($parentGroup) {
            $childGroup = new ProductGroup($childGroupName, $parentGroup);
            $this->service->addChildGroup($parentGroup, $childGroup);
            return $childGroup;
        }
        return null;
    }
}
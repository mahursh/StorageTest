<?php

namespace Service;

use Repository\ProductGroupRepository;


class ProductGroupService
{

    private $repository;

    public function __construct(ProductGroupRepository $repository)
    {
        $this->repository = $repository;
    }

    public function saveProductGroup(\ProductGroup $productGroup)
    {
        $this->repository->save($productGroup);
    }

    public function updateProductGroup(\ProductGroup $productGroup)
    {
        $this->repository->update($productGroup);
    }

    public function getProductGroupById($id)
    {
        return $this->repository->findById($id);
    }

    public function getChildrenByParentId($parentId)
    {
        return $this->repository->findAllChildrenByParentId($parentId);
    }

    public function getParentByChildGroupId($childGroupId)
    {
        return $this->repository->findParentByChildGroupId($childGroupId);
    }

    public function fetchChildGroups(\ProductGroup $productGroup)
    {
        $this->repository->fetchChildGroups($productGroup);
    }

    public function addChildGroup(\ProductGroup $parentGroup, \ProductGroup $childGroup)
    {
        $this->repository->addChildGroup($parentGroup, $childGroup);
    }

}
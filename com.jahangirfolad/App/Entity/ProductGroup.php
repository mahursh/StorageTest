<?php

class ProductGroup
{

    private $id;
    private $name;
    private $parentGroup;
    private $childGroupList = [];


    public function __construct($name = null, $parentGroup = null)
    {
        $this->name = $name;
        $this->parentGroup = $parentGroup;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getParentGroup()
    {
        return $this->parentGroup;
    }

    public function setParentGroup($parentGroup)
    {
        $this->parentGroup = $parentGroup;
    }

    public function getChildGroupList()
    {
        return $this->childGroupList;
    }

    public function addChildGroup(ProductGroup $childGroup)
    {
        $this->childGroupList[] = $childGroup;
    }

    public function __toString()
    {
        return sprintf(
            "ProductGroup [ID: %d, Name: %s, ParentGroupID: %s]",
            $this->id,
            $this->name,
            $this->parentGroup ? $this->parentGroup->getId() : 'None'
        );
    }

}
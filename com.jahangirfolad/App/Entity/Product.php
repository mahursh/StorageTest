<?php

class Product
{


    private $id;
    private $name;
    private $unit;
    private $productGroup;

    public function  __construct($name, $unit = null, $productGroup = null){
        $this->name = $name;
        $this->unit = $unit;
        $this->productGroup = $productGroup;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getUnit()
    {
        return $this->unit;
    }

    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

    public function getProductGroup()
    {
        return $this->productGroup;
    }

    public function setProductGroup($productGroup)
    {
        $this->productGroup = $productGroup;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function __toString()
    {
        return sprintf(
            "Product [ID: %d, Name: %s, Unit: %s, ProductGroup: %s]",
            $this->id,
            $this->name,
            $this->unit ? $this->unit->getName() : 'None',
            $this->productGroup ? $this->productGroup->getName() : 'None'
        );
    }

}
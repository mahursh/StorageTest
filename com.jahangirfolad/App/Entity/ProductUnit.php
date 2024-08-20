<?php

namespace Entity;

class ProductUnit
{

    private $id;
    private $name;

    public function __construct($name = null){
        $this->name = $name;
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

    public function __toString()
    {
        return sprintf(
            "Product [ID: %d, Name: %s]",
            $this->id,
            $this->name

        );
    }

}
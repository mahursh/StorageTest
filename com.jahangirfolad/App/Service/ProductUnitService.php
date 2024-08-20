<?php

namespace Service;

use Repository\ProductUnitRepository;
use Entity\ProductUnit;
class ProductUnitService

{

    private $repository;

    public function __construct(ProductUnitRepository $repository)
    {
        $this->repository = $repository;
    }

    public function save(ProductUnit $productUnit)
    {
        $this->repository->save($productUnit);

    }

    public function update(ProductUnit $productUnit)
    {
        $this->repository->update($productUnit);
    }

    public function getUnitById($id)
    {
        return $this->repository->findById($id);
    }

    public function getAllUnits()
    {
        return $this->repository->findAll();
    }
}
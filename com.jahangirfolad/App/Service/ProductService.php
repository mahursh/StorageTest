<?php

namespace Service;

use Product;
use Repository\ProductRepository;

class ProductService
{

    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function saveProduct(Product $product)
    {
        $this->repository->save($product);
    }

    public function updateProduct(Product $product)
    {
        $this->repository->update($product);
    }

    public function getProductById($id)
    {
        return $this->repository->findById($id);
    }

}
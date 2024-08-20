<?php

namespace Controller;

use Product;
use Service\ProductService;

class ProductController
{

    private $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function createProduct($name, $unit, $productGroup)
    {
        $product = new Product($name, $unit, $productGroup);
        $this->service->saveProduct($product);
        return $product;
    }

    public function updateProduct($id, $name, $unit, $productGroup)
    {
        $product = $this->service->getProductById($id);
        if ($product) {
            $product->setName($name);
            $product->setUnit($unit);
            $product->setProductGroup($productGroup);
            $this->service->updateProduct($product);
        }
        return $product;
    }

    public function getProduct($id)
    {
        return $this->service->getProductById($id);
    }

}
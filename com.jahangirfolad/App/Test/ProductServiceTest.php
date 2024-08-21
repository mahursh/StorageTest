<?php

namespace Test;

use PDO;
use Product;
use Entity\ProductUnit;

use ProductGroup;
use Repository\ProductRepository;
use Service\ProductService;
use Controller\ProductController;

require_once '../Entity/Product.php';
require_once '../Repository/ProductRepository.php';
require_once '../Service/ProductService.php';
require_once '../Controller/ProductController.php';
require_once '../Entity/ProductUnit.php';
require_once '../Entity/ProductGroup.php';

$pdo = new PDO('mysql:host=localhost;dbname=storage2', 'root', '');

$unit = new ProductUnit("kg");
$group = new ProductGroup("Esfahan");




$repository = new ProductRepository($pdo);
$service = new ProductService($repository);
$controller = new ProductController($service);



$product = $controller->createProduct("rebar" ,$unit , $group);

<?php

namespace Test;

use PDO;
use Product;
use Repository\ProductRepository;
use Service\ProductService;


require_once '../Repository/ProductRepository.php';
require_once '../Entity/Product.php';
require_once '../Service/ProductService.php';



$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');


$repository = new ProductRepository($pdo);

$service = new ProductService($repository);



$product = new Product("rebar" , "kg");

$service->saveProduct($product);
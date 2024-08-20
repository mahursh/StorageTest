<?php

namespace Test;

use Entity\ProductUnit;
use PDO;
use Product;
use Repository\ProductUnitRepository;
use Service\ProductUnitService;

$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');

$repository = new ProductUnitRepository($pdo);
$service = new ProductUnitService($repository);

$unit = new ProductUnit("kg");

$service->save($unit);

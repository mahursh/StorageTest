<?php

namespace Test;

use Entity\ProductUnit;
use PDO;
use Repository\ProductUnitRepository;
use Service\ProductUnitService;

require_once '../Repository/ProductUnitRepository.php';
require_once '../Entity/ProductUnit.php';
require_once '../Service/ProductUnitService.php';

$pdo = new PDO('mysql:host=localhost;dbname=storage2', 'root', '');

$repository = new ProductUnitRepository($pdo);
$service = new ProductUnitService($repository);

$unit = new ProductUnit("kg");

$service->save($unit);

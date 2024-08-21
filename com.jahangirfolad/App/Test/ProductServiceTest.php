<?php

namespace Test;

use PDO;
use Product;
use Entity\ProductUnit;

use ProductGroup;
use Repository\ProductRepository;
use Service\ProductService;
use Controller\ProductController;

use Repository\ProductGroupRepository;
use Service\ProductGroupService;
use Repository\ProductUnitRepository;
use Service\ProductUnitService;

require_once '../Repository/ProductUnitRepository.php';
require_once '../Entity/ProductUnit.php';
require_once '../Service/ProductUnitService.php';

require_once '../Repository/ProductGroupRepository.php';
require_once '../Entity/ProductGroup.php';
require_once '../Service/ProductGroupService.php';

require_once '../Entity/Product.php';
require_once '../Repository/ProductRepository.php';
require_once '../Service/ProductService.php';
require_once '../Controller/ProductController.php';
require_once '../Entity/ProductUnit.php';
require_once '../Entity/ProductGroup.php';

$pdo = new PDO('mysql:host=localhost;dbname=storage2', 'root', '');


$unitRepository = new ProductUnitRepository($pdo);
$groupRepository = new ProductGroupRepository($pdo);
$unitService = new ProductUnitService($unitRepository);
$groupService = new ProductGroupService($groupRepository);


$unit = new ProductUnit("kg");
$group = new ProductGroup("Esfahan");
$unitService->save($unit);
$groupService->saveProductGroup($group);

$repository = new ProductRepository($pdo);
$service = new ProductService($repository);
$controller = new ProductController($service);



$product = $controller->createProduct("rebar" , $unit->getId(),$group->getId() );

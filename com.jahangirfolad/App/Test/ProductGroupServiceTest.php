<?php
 namespace Test;

use PDO;
use ProductGroup;
use Repository\ProductGroupRepository;
use Service\ProductGroupService;

require_once '../Repository/ProductGroupRepository.php';
require_once '../Entity/ProductGroup.php';
require_once '../Service/ProductGroupService.php';

$pdo = new PDO('mysql:host=localhost;dbname=storage', 'root', '');

$repository = new ProductGroupRepository($pdo);

$service = new ProductGroupService($repository);



$productGroup = new ProductGroup("Electronics");
$service->saveProductGroup($productGroup);
//echo "Test Save: " . ($productGroup->getId() ? "Passed" : "Failed") . "\n";
//echo $productGroup ;
//echo "\n____________________________\n";

$childGroup1 = new ProductGroup("Mobile");
$service->addChildGroup($productGroup ,$childGroup1);
//echo $childGroup1;
//echo "\n____________________________\n";

$childGroup2 = new ProductGroup("Tablet");
$service->addChildGroup($productGroup ,$childGroup2);
//echo $childGroup2;
//echo "\n___________________________\n";

$childGroup3 = new ProductGroup("Samsung");
$service->addChildGroup($childGroup1 ,$childGroup3);
//echo $childGroup3;
//echo "\n____________________________\n";

$parentGroup = $service->getParentByChildGroupId($childGroup3->getId());
//echo $parentGroup;
//echo "\n____________________________\n";

$fetchedGroup = $service->getProductGroupById($productGroup->getId());
//echo $fetchedGroup;
//echo "\n____________________________\n";

$fetchedGroup->setName("Changed");
$service->updateProductGroup($fetchedGroup);
//echo  $service->getProductGroupById($productGroup->getId());
//echo "\n____________________________\n";

$fetchedChildGroup = $service->fetchChildGroups($productGroup);
//foreach ($fetchedChildGroup as $childGroup){
//    echo $childGroup;
//    echo "\n";
//}
//echo "\n____________________________\n";

$children = $service->getChildrenByParentId($productGroup->getId());
//
//foreach ($children as $child) {
//    echo $child;
//    echo "\n";
//}
// echo "\n____________________________\n";




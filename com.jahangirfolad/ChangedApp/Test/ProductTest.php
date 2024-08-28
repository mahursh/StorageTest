<?php

use Model\ProductModel;
require_once __DIR__ . '/../Library/Database.php';
require_once '../Library/Database.php';
require_once '../Model/ProductModel.php';
require_once '../Model/ProductGroupModel.php';

function runProductTests() {
    $productModel = new ProductModel();
    $productGroupModel = new ProductGroupModel();


    $name = "Electronic";
    $mainGroupId = $productGroupModel->save($name , null);

    $childName = "Laptop";
    $productGroupModel->addChildGroup($mainGroupId, $childName);

    $childName2 = "Asus" ;
    $productGroupModel->addChildGroup($mainGroupId, $childName2);

    $childName3 = "K256";
    $productGroupModel->addChildGroup($mainGroupId, $childName3);

    $category = "Test";
    $productId = $productModel->save($category,$mainGroupId);

    $childGroupNames  = $productModel->getAllChildGroupNames($productId);
//  foreach ($childGroupNames as $groupName) {
//      echo "- " . $groupName . "\n";
//  }

    print_r($childGroupNames);










}

runProductTests();

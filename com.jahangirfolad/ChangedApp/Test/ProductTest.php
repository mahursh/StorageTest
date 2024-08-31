<?php

use Model\ProductModel;
require_once __DIR__ . '/../Library/Database.php';
require_once '../Library/Database.php';
require_once '../Model/ProductModel.php';
require_once '../Model/ProductGroupModel.php';

function runProductTests() {
    $productModel = new ProductModel();
    $productGroupModel = new ProductGroupModel();

//
//    $name = "Electronic";
//    $mainGroupId = $productGroupModel->save($name , null);
//
//    $childName = "Laptop";
//    $productGroupModel->addChildGroup($mainGroupId, $childName);
//
//    $childName2 = "Asus" ;
//    $productGroupModel->addChildGroup($mainGroupId, $childName2);
//
//    $childName3 = "K256";
//    $productGroupModel->addChildGroup($mainGroupId, $childName3);
//    ----------------------------------------------------------------

//
//    $name2 = "Electronic";
//    $mainGroupId2 = $productGroupModel->save($name2 , null);
//
//    $childName4 = "Mobile";
//    $productGroupModel->addChildGroup($mainGroupId2, $childName4);
//
//    $childName5 = "Samsung";
//    $productGroupModel->addChildGroup($mainGroupId2, $childName5);
//
//    $childName6 = "GalaxyNote8";
//    $productGroupModel->addChildGroup($mainGroupId2, $childName6);

//    -------------------------------------------------------------------

//    $name3 = "Beauty";
//    $mainGroupId3 = $productGroupModel->save($name3 , null);
//
//    $childName7 = "Face";
//    $productGroupModel->addChildGroup($mainGroupId3, $childName7);
//
//    $childName8 = "LipStick";
//    $productGroupModel->addChildGroup($mainGroupId3, $childName8);

//    -------------------------------------------------------------------

//
//    $category = "DigiKala";
//    $productId = $productModel->save($category,$mainGroupId);
//
//    $category2 = "Snap";
//    $productId2 = $productModel->save($category2,$mainGroupId2);
//
//    $category3 ="DigiKala";
//    $productId3 = $productModel->save($category3,$mainGroupId3);

//    $childGroupNames  = $productModel->getAllChildGroupNames($productId);
//  foreach ($childGroupNames as $groupName) {
//
//      echo $groupName->name  . "\n";
//  }
  //    print_r($childGroupNames);

    $products = $productModel->findProductByProductGroup('Electronic' , 'Mobile' , 'GalaxyNote8' );
    foreach ($products as $product) {
        echo $product->category . "\n";
        echo $product->id . "\n";
    }


}

runProductTests();

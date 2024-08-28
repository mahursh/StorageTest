<?php

use Model\ProductModel;
require_once __DIR__ . '/../Library/Database.php';
require_once '../Library/Database.php';
require_once '../Model/ProductModel.php'; // Adjust the path as needed
require_once '../Model/ProductGroupModel.php'; // Adjust the path as needed

function runProductTests() {
    $productModel = new ProductModel();
    $productGroupModel = new ProductGroupModel();

    // Test 1: Save a new product and link to a product group
    echo "Running Test 1: Save a new product and link to a product group\n";
    $productGroupId = $productGroupModel->save("Electronics");
    $productId = $productModel->save("Laptop", $productGroupId);
    echo "New Product ID: $productId\n";

    // Test 2: Save another product in the same group
    echo "Running Test 2: Save another product in the same group\n";
    $anotherProductId = $productModel->save("Smartphone", $productGroupId);
    echo "New Product ID: $anotherProductId\n";

    // Test 3: Fetch product by ID
    echo "Running Test 3: Fetch product by ID\n";
    $product = $productModel->findById($productId);
    echo "Fetched Product: " . $product->category . " (ID: " . $product->id . ")\n";

    // Test 4: Update product details
    echo "Running Test 4: Update product details\n";
    $productModel->update($productId, "Gaming Laptop", $productGroupId);
    $updatedProduct = $productModel->findById($productId);
    echo "Updated Product: " . $updatedProduct->category . " (ID: " . $updatedProduct->id . ")\n";

    // Test 5: Fetch all products
    echo "Running Test 5: Fetch all products\n";
    $allProducts = $productModel->findAll();
    echo "All Products:\n";
    foreach ($allProducts as $prod) {
        echo "- " . $prod->category . " (ID: " . $prod->id . ")\n";
    }

    echo "Running Test 6: Fetch all child groups of the product's group\n";
    $childGroupNames = $productModel->getAllChildGroupNames($productId);

    if (empty($childGroupNames)) {
        echo "Child Groups of Product's Group: None\n";
    } else {
        echo "Child Groups of Product's Group:\n";
        foreach ($childGroupNames as $groupName) {
            echo "- " . $groupName . "\n";
        }
    }

}

runProductTests();

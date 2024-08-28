<?php

// Assuming the test database and product_group_tbl are already set up
require_once '../Library/Database.php'; // Adjust the path as needed
require_once '../Model/ProductGroupModel.php';

function runTests() {
    $model = new ProductGroupModel();

    // Test 1: Save a new product group
    echo "Running Test 1: Save a new product group\n";
    $parentGroupId = null;
    $name = "Electronics";
    $newGroupId = $model->save($name, $parentGroupId);
    echo "New Group ID: " . $newGroupId . "\n";

    // Test 2: Save a child product group
    echo "Running Test 2: Save a child product group\n";
    $childName = "Laptops";
    $model->addChildGroup($newGroupId, $childName);


//    echo "Child Group ID: " . $childGroupId . "\n";

//    // Test 3: Edit the child product group
//    echo "Running Test 3: Edit the child product group\n";
//    $updatedChildName = "Gaming Laptops";
//    $model->edit($childGroupId, $updatedChildName, $newGroupId);
//    echo "Updated Child Group Name: " . $updatedChildName . "\n";
//
//    // Test 4: Find the child group by ID
//    echo "Running Test 4: Find the child group by ID\n";
//    $childGroup = $model->findById($childGroupId);
//    if ($childGroup) {
//        echo "Found Child Group: " . $childGroup->name . "\n";
//    } else {
//        echo "Child Group not found\n";
//    }
//
//    // Test 5: Find all children by parent ID
//    echo "Running Test 5: Find all children by parent ID\n";
//    $children = $model->findAllChildrenByParentId($newGroupId);
//    echo "Children of Group ID $newGroupId:\n";
//    foreach ($children as $child) {
//        echo "- " . $child->name . "\n";
//    }
//
//    // Test 6: Find the parent by child group ID
//    echo "Running Test 6: Find the parent by child group ID\n";
//    $parentGroup = $model->findParentByChildGroupId($childGroupId);
//    if ($parentGroup) {
//        echo "Parent Group of Child Group ID $childGroupId: " . $parentGroup->name . "\n";
//    } else {
//        echo "Parent Group not found\n";
//    }
//
     // Test 7: Add a child group and update the child group list
    echo "Running Test 7: Add a child group and update the child group list\n";
    $anotherChildName = "Smartphones";
    $model->addChildGroup($newGroupId, $anotherChildName);
//    $childGroups = $model->fetchChildGroups($newGroupId);
//    echo "Updated Child Groups of Group ID $newGroupId:\n";
//    foreach ($childGroups as $group) {
//        echo "- " . $group->name . "\n";
//    }
}

// Run the tests
runTests();




<?php

require(__DIR__ . '/Category.php');
require(__DIR__ . '/Product.php');
require(__DIR__ . '/OneToMany.php');
require(__DIR__ . '/NormalizeData.php');



$categoryModel = new Category();


$data = $categoryModel
    ->select('category.id, name')
    ->with('products')
    ->get();
echo '<pre>';
print_r($data);









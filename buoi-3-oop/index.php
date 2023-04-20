<?php
require (__DIR__ . '/Product.php');
$productModel = new Product();
$productModel->create([
   'name'=>'sp3',
   'description' =>'anh',
   'price' => 100
]);

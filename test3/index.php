<?php
require (__DIR__ . '/Product.php');

$product = new Product();
//$product->insert([
//    'name' => 'anh',
//    'price'=> 100,
//    'descriptions'=> 'fighting'
//]);

$product
    ->select('name')
//        ->find([1,4,5],'*');
//    ->where('id', '1')
    ->limit(2,1)
//    ->join('products_clone','products.id = products_clone.clone_id')
    ->get();

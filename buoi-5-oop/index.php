<?php
require(__DIR__ . '/Product.php');
$product_model = new Product();

//
//$product_model->name = 'name';
//$product_model->price = '100';
//$product_model->setname('product');
//$product_model
//    ->save($product_model);
//    ->insert();
//$data = $product_model
//    ->where('id', '2')
//    ->select('')
////    ->join('product_tab','products.id = product_tab.product_id')
//////    ->groupBy('dfe')
//////    ->having('ssadd')
//////    ->orderBy('234')
//////    ->limit(2,1)
//-> whereArray(
//    [
//        ['name', '=', 'name'],
//        ['price', '>', 100]
//    ]
//)
//    ->get();

// eager loading



// 1 .Lấy 1 bản ghi
// 2.Tìm theo id
// 3. Làm 1 số case special và eager loading

//1 số case special và eager loading
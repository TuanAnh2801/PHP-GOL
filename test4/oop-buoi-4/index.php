cd<?php
require(__DIR__ . '/Product.php');
require(__DIR__ . '/Test.php');
require(__DIR__ . '/Category.php');
require(__DIR__ . '/OneToMany.php');
require(__DIR__ . '/Branchs.php');



//$productModel = new Product();
//$productModel->manyToMany();
// $id = $productModel->insert([
//     'name' => 'san-pham-1',
//     'price' => 100,
//     'decription' => 'mo-ta-1'
// ]);

// ->where('id', 1)
// ->where('id', '>', 1)

// $productModel
// ->where('id', 1)
// ->update([
//     'name' => 'duc789',
//     'price' => 5000
// ]);

// $data = $productModel
// ->select('products.id, name, decription, product_tag.name_tag')
// ->join('product_tag', 'products.id = product_tag.product_id')
// ->where('products.id', 3)
// ->groupBy('name')
// ->orderBy('name desc')
// // ->limit(2, 1)
// ->get();

// echo "<pre>";
// print_r($data);

// $productModel->setName('product1');
// $productModel->save($productModel);

// echo "<pre>";
// print_r($productModel);


//->select('products.id, name, decription')
//->with('comments');
//->get();

//
//echo "<pre>";
//print_r($data);



// echo "<pre>";
// print_r($productModel);

// eager loading
// $productModel->test();

// $productModel->comments;
$category = new Category();
$category->select('id , name')
    ->with(['product','branch'])
    ->get();








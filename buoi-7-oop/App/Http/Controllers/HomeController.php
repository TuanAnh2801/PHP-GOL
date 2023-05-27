<?php

namespace App\Http\Controllers;

use View\View;
use Model\Product;

class HomeController
{
    public function index()
    {
        $productModel = new Product();
        $products = $productModel->get();
        if (isset($_SESSION['success'])) {
            $message = $_SESSION['success'];
        }
        unset($_SESSION['success']);
        if (isset($_SESSION['error'])) {
            $message = $_SESSION['error'];
        }
        unset($_SESSION['error']);
        View::render('home/index.php', [
            'productInfo' => $products,
            'message' => $message ?? null
        ]);

    }

    public function create()
    {
        View::render('home/create.php');
        $requestMeethod = $_SERVER['REQUEST_METHOD'];
        $productModel = new Product();
        if ($requestMeethod === 'POST') {
            echo '<pre>';
            if ($_FILES['avatar']['error'] == 0) {
                $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                $extension = strtolower($extension);
                $size = $_FILES['avatar']['size'] / 1024 / 1024;
                $size = round($size, 2);
                $tmp = ['pnp', 'jpg', 'jpeg', 'gif'];
                if (!in_array($extension, $tmp)) {
                    $_SESSION['error'] = 'anh k dung dinh dang';

                } elseif ($size > 10) {
                    $_SESSION['error'] = 'kich thuoc anh qua lon';

                } else {
                    $dir = 'assets/uploads';
                    if (!file_exists($dir)) {
                        mkdir($dir);
                    }
                    $filename = time() . '-anh- ' . $_FILES['avatar']['tmp_name'];
               $value = move_uploaded_file($_FILES['avatar']['tmp_name'],$dir . '/' .$filename);
                }
                $is_insert = $productModel->insert([
                    'name' => $_POST['name'],
                    'price' => $_POST['price'],
                    'description' => $_POST['description'],
                    'avatar' => $filename
                ]);
            }
            if ($is_insert) {
                $_SESSION['success'] = 'Create du lieu thanh cong';
            } else {
                $_SESSION['error'] = 'Create du lieu that bai';
            }
//            header('Location:/');

        }
    }

    public function edit()
    {
        $id = $_GET['id'];
        $productModel = new Product();
        $productModel->where('id', $id);
        $product = $productModel->selectId($id);
        View::render('home/edit.php', [
            'products' => $product
        ]);
        $requestMeethod = $_SERVER['REQUEST_METHOD'];
        if ($requestMeethod === 'POST') {
            $is_update = $productModel->update([
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'description' => $_POST['description'],
//                'avatar' => $_POST['avatar']

            ]);
            if ($is_update) {
                $_SESSION['success'] = 'Update du lieu thanh cong';
            } else {
                $_SESSION['error'] = 'Update du lieu that bai';
            }
            header('Location:/');
        }

    }

    public function delete()
    {
        $id = $_GET['id'];
        $productModel = new Product();
        $productModel->where('id', $id);
        $is_delete = $productModel->delete();
        if ($is_delete) {
            $_SESSION['success'] = 'Delete du lieu thanh cong';
        } else {
            $_SESSION['error'] = 'Delete du lieu that bai';
        }
        header('Location:/');
    }
}
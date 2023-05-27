<?php
session_start();
//require $rootDir . 'App/Http/Controllers/HomeController.php';
//require $rootDir . 'App/Http/Controllers/NewController.php';
// 1. Require file autoload
require  __DIR__ . '/autoload/autoload.php';
// 2. Định tuyến controller, action dựa vào hệ thống routing build in

// 3. dispatchRoute
$pathCurrent = $_SERVER['REQUEST_URI'];
$routeinstance = new \Router\Route();
require __DIR__ . '/Router/web.php';

$routeinstance->dispatchRoute($pathCurrent);

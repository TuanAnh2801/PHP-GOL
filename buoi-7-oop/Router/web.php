<?php

$routeinstance->addRoute('/',[
    'controller' => 'App\Http\Controllers\HomeController',
    'action' => 'index'
]);
$routeinstance->addRoute('/news',[
    'controller' => 'App\Http\Controllers\NewController',
    'action' => 'index'
]);
$routeinstance->addRoute('/product/add',[
    'controller' => 'App\Http\Controllers\HomeController',
    'action' => 'create'
]);
$routeinstance->addRoute(
    '/product/edit',
    [
        'controller' => 'App\Http\Controllers\HomeController',
        'action' => 'edit'
    ]
);
$routeinstance->addRoute(
    '/product/delete',
    [
        'controller' => 'App\Http\Controllers\HomeController',
        'action' => 'delete'
    ]
);


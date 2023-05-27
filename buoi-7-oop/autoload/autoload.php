<?php
spl_autoload_register(
    function ($class) {
        $classDir = __DIR__.'/../'. $class . '.php';
//        var_dump($classDir);
        require $classDir;
    }
);

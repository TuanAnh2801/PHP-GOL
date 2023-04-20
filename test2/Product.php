<?php
require (__DIR__ .'/BaseModel.php');
 class Product extends BaseModel{
     protected $table = 'products';
     public function __construct()
     {
        parent::__construct($this->table);
     }
 }
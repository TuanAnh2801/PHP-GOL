<?php

require(__DIR__ . '/Model.php');
require(__DIR__ . '/Comment.php');

class Product extends Model {

    protected $table = 'products';

   
    public function comments()
    {
        return $this->hasMany(Comment::class, 'product_id');
    }

    
    
}
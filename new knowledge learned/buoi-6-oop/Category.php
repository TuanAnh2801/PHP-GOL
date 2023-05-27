<?php

require(__DIR__ . '/Model.php');

class Category extends Model {

    protected $table = 'category';


    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }



}

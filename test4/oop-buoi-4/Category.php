<?php

class Category extends Model
{
    protected $table = 'category';

    public function product()
    {
        return $this->hasMany(Product::class, 'category_id');

    }
    public function branch()
    {
        return $this->hasMany(Branchs::class, 'category_id');

    }
}
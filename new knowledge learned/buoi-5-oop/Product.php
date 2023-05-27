<?php
require(__DIR__ . '/Model.php');

class Product extends Model
{
    private $name;
    private $filable = [
        'name',
    ];

    protected $table = 'products';

    public function getFilable()
    {
        return $this->filable;
    }

    public function setname($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
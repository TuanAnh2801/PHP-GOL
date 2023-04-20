<?php

class MinValidate
{
private $min;

    public function __construct($optional)
    {
    $this->min = $optional;
    }

    public function passValidate($filedname, $valueRule)
    {
        if ($this->min <= $valueRule){
            return true;
        }
        return false;
    }


    public function getMessage($filedname)
    {
        return $filedname. 'number k hop le';
    }
}

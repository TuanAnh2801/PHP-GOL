<?php

class BetweenValidate
{


    public function __construct($min,$max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function passValidate($filedname, $valueRule)
    {
        if ( $this->min <= strlen($valueRule) && strlen($valueRule)<= $this->max){
            return true;
        }
        return false;
    }


    public function getMessage($filedname)
    {
        return $filedname. 'chuoi k hop le';
    }
}


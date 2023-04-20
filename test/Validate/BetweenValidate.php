<?php
class BetweenValidate{
    private $min;
    private $max;
    public function __construct($min,$max)
    {
        $this->min =$min;
        $this->max =$max;
    }
    public function passValidate($filedname,$valueRule){
        if ( $this->min <= strlen($valueRule) && strlen($valueRule) <=   $this->max ){
            return true;
            }
        return false;
    }
    public function getMessage(){
       return ' chuoi k hop le ';
    }
}
<?php
class MinValidate{
    private $min;
    public function __construct($min)
    {
        $this->min = $min;
    }
    public function passValidate($filedname,$valueRule){
        if (strlen($valueRule) >= $this->min ){
            return true;
        }
        return false;
    }
    public function getMessage($filedname){
        return $filedname . ' number chuoi k hop le ';
    }
}

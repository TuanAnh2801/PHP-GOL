<?php
class MinValidate{
    private $fieldValue;
    private $min;
    public function __construct($filedValue,$min)
    {
        $this->fieldValue= $filedValue;
        $this->min = $min;
    }
    public function passValidate(){
        if (strlen($this->fieldValue) >= $this->min) {
        return true;

    }
        return false;
    }
    public function getMessage(){
        return 'number k hop le';
    }
}

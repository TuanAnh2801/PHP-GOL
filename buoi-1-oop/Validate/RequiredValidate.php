<?php
class RequiredValidate{
    private $fieldValue;
    public function __construct($filedValue)
    {
    $this->fieldValue= $filedValue;
    }
    public function passValidate(){
        if ($this->fieldValue){
            return true;
        }
        return false;
    }
    public function getMessage(){
        return 'not empty';
    }
}
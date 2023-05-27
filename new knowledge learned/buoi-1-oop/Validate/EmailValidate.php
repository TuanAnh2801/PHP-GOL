<?php
class EmailValidate{
    private $fieldValue;
    public function __construct($filedValue)
    {
        $this->fieldValue= $filedValue;
    }
    public function passValidate(){
        if (filter_var( $this->fieldValue, FILTER_VALIDATE_EMAIL)) {
          return true;
        }
        return false;
    }
    public function getMessage(){
        return 'email k hop le';
    }
}
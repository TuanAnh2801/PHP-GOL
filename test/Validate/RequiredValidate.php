<?php
class RequiredValidate{


    public function passValidate($filedname,$valueRule){
        if ($valueRule){
            return true;
        }
        return false;
    }
    public function getMessage($filedname,$message){
       if ($message){
           return $message;
       }
    }
}
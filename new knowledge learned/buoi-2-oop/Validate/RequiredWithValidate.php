<?php

class RequiredWithValidate
{
    private $min;
    public function __construct($filenamRequiredWith)
    {
        $this->filenamRequiredWith = $filenamRequiredWith;
    }

    public function passValidate($filedname, $valueRule,$dataForm)
    {
            if ($valueRule && !$dataForm[$this->filenamRequiredWith]){
                return false;
            }
            return true;
    }


    public function getMessage($filedname,$message)
    {
        return  'required with name';
    }
}


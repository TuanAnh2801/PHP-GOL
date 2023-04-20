<?php
require(__DIR__ . '/Validate/RequiredValidate.php');
require(__DIR__ . '/Validate/EmailValidate.php');
require(__DIR__ . '/Validate/MinValidate.php');
require(__DIR__ . '/Validate/BetweenValidate.php');
require(__DIR__ . '/Validate/RequiredWithValidate.php');




class ValidateService
{
    private $dataForm = [];
    private $rules = [];
    private $errors = [];
    private $message=[] ;
    private $ruleMapsClass = [
        'required' => RequiredValidate::class,
        'email' => EmailValidate::class,
        'min' => MinValidate::class,
        'between' => BetweenValidate::class,
        'required_with'=> RequiredWithValidate::class
    ];

    public function __construct($dataForm)
    {
        $this->dataForm = $dataForm;

    }

    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    public function setMessage($message){
        $this->message = $message;
    }

    public function validate()
    {
// B1: Chuẩn đầu vào
// B2: Thực hiện validation
        foreach ($this->rules as $filedname => $ruleArray) {
            $valueRule = $this->dataForm[$filedname];


            foreach ($ruleArray as $ruleItem) {
                $ruleAndOptional = explode(":", $ruleItem);
                $ruleName = $ruleAndOptional[0];
                $optional = explode(",",end($ruleAndOptional));


                $className = $this->ruleMapsClass[$ruleName];
                $classNameInstance = new $className(...$optional);
                if (!$classNameInstance->passValidate($filedname, $valueRule,$this->dataForm)) {
//                    add message
                    $keyMessage = $filedname . '.'.$ruleName;
                    $this->errors[$filedname][] = $classNameInstance->getMessage($filedname,$this->message[$keyMessage] ?? null);
                }
            }
        }

    }



    public function getErrors()
    {
        return $this->errors;
    }

}
<?php
require (__DIR__ . '/Validate/BetweenValidate.php');
require (__DIR__ . '/Validate/EmailValidate.php');
require (__DIR__ . '/Validate/MinValidate.php');
require (__DIR__ . '/Validate/RequiredValidate.php');
require (__DIR__ . '/Validate/RequiredWithValidate.php');

class validate{
    private $dataForm = [];
    private $rules =[];
    private $message = [];
    private $erros = [];

    private $rulesMap=[
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
    public function setRules($rules){
        $this->rules = $rules;

    }
    public function setMessage($message){
        $this->message = $message;

    }
    public function validate(){
        foreach ($this->rules as $filedname =>$ruleArray){
            $valueRule = $this->dataForm[$filedname];
            foreach ($ruleArray as $ruleItem){
                $ruleOption = explode(":",$ruleItem);
                $ruleName = $ruleOption[0];
                $optional = explode(",",end($ruleOption));
                $className = $this->rulesMap[$ruleName];
                $classNameInstance = new $className(...$optional);

               if(!$classNameInstance->passValidate($filedname,$valueRule,$this->dataForm)){
                   $keyname = $filedname . "." . $ruleName;
                   $this->erros[$filedname][] = $classNameInstance->getMessage($filedname,$this->message[$keyname] ?? null);
               }

            }
        }
    }
    public function getErrors(){
        return $this->erros;
    }
}


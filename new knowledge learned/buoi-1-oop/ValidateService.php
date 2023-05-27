<?php
require(__DIR__ . '/Validate/RequiredValidate.php');
require(__DIR__ . '/Validate/EmailValidate.php');
require(__DIR__ . '/Validate/MinValidate.php');


class ValidateService
{
    private $dataForm = [];
    private $rules = [];
    private $errors = [];

    public function __construct($dataForm)
    {
        $this->dataForm = $dataForm;
    }

    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    public function validate()
    {


        foreach ($this->rules as $filed => $rule) {
            $fieldValue = $this->dataForm[$filed];

            if (strpos($rule, "|")) {
                $ruleArray = explode("|", $rule);

                foreach ($ruleArray as $ruleItem) {
                    if (strpos($ruleItem, ":")) {
                        $ruleOptional = explode(":", $ruleItem);
                        $functionValidate = ucfirst(reset($ruleOptional)) . 'Validate';
                        $min = end($ruleOptional);

                        $instance = new $functionValidate($fieldValue, $min);
                        $instance->passValidate();
                        if (!$instance->passValidate()) {
                            $message = $filed . $instance->getMessage();
                            $this->errors[$filed][] = $message;

                        }
                    } else {
                        $this->addErrorsValidate($ruleItem, $fieldValue, $filed);
                    }
                }

            } else {
                $this->addErrorsValidate($rule, $fieldValue, $filed);


            }
        }


    }

    private function addErrorsValidate($ruleItem, $fieldValue, $filed)
    {
        $classNameValidate = ucfirst($ruleItem) . 'Validate';
        $instance = new $classNameValidate($fieldValue);

        if (!$instance->passValidate()) {
            $message = $filed . $instance->getMessage();
            $this->errors[$filed][] = $message;

        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
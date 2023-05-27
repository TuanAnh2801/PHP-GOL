<?php
$dataForm = [
    'name' => "",
    'email' => "",
    'first_name' => "",

];
$rules = [
    'name' => 'required',
    'email' => 'required|email|min:3',
    'first_name' => 'required',
];
require(__DIR__ . '/ValidateService.php');
// init data
$validate = new ValidateService($dataForm);
$validate->setRules($rules);
$validate->validate();
echo "<pre>";

echo "<pre>";
print_r($validate->getErrors());



//$errors = [];
// Validate

//foreach ($rules as $filed => $rule) {
//    $valueRule = $dataForm[$filed];
//    if (strpos($rule, "|")) {
//        $ruleArray = explode("|", $rule);
//        foreach ($ruleArray    as $ruleItem) {
////            if (strpos($rule, ":")) {
//                $ruleOptional = explode(":", $ruleItem);
//                $functionValidate = reset($ruleOptional) . 'Validate';
//                $functionValidate($valueRule, $filed, end($ruleOptional));
//
//                foreach ($ruleArray as $ruleItem) {
//                    if (strpos($rule, ":")) {
//                        $ruleMax = explode(":", $ruleItem);
//
//
//                        $functionValidate = reset($ruleMax) . 'Validate';
//                        $functionValidate($valueRule, $filed, end($ruleOptional));
//
//                    } else {
//                        $functionValidate = $ruleItem . 'Validate';
//
//                        //    function call validate dynamic
//                        $functionValidate($valueRule, $filed);
//                    }
//
//
//                }
//
//            } else {
//                $functionValidate = $ruleItem . 'Validate';
//
//                //    function call validate dynamic
//                $functionValidate($valueRule, $filed);
//            }
//
//
//        }
//    } else {
//        $functionValidate = $rule . 'Validate';
//
//        //    function call validate dynamic
//        $functionValidate($valueRule, $filed);
//
//    }
//
//
//}
//
////    required validate
//function requiredValidate($valueRule, $fieldName)
//{
//    global $errors;
//    if (!$valueRule) {
//        $errors[$fieldName][] = $fieldName . 'not empty';
//    }
//
//
//}
//
//function emailValidate($valueRule, $fieldName)
//{
//    global $errors;
//    if (!filter_var($valueRule, FILTER_VALIDATE_EMAIL)) {
//        $errors[$fieldName][] = $fieldName . 'not format email';
//    }
//
//
//}
//
//function minValidate($valueRule, $fieldName, $min)
//{
//    global $errors;
//    if (strlen($valueRule) < $min) {
//        $errors[$fieldName][] = $fieldName . 'min character ';
//    }
//
//
//}
//
//function maxValidate($valueRule, $fieldName, $max)
//{
//    global $errors;
//    if (strlen($valueRule) < $max) {
//        $errors[$fieldName][] = $fieldName . 'max character ';
//    }
//
//
//}
//


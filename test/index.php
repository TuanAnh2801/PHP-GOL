<?php
$dataForm = [
    'name' => "",
    'email' => "",

];
$rules = [

    'name' => 'required',
    'email' => 'required|email|min:3|between:3,10|required_with:name'
];
require (__DIR__ . '/validate.php');
$message = [
    'name.required' => 'ban phai nhap ten',
    'email.required'=> 'ban phai nhap email'
];

foreach ($rules as $filename => $ruleArray){
    $rules[$filename] = explode("|",$ruleArray);

}

$validate = new validate($dataForm);
$validate->setMessage($message);
$validate->setRules($rules);
$validate->validate();
echo '<pre>';
print_r($validate->getErrors());

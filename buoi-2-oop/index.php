<?php
$dataForm = [
    'name' => "",
    'email' => "",

];
$rules = [
//    'name' => ['required'],
//    'email' => [
//        'required',
//        'email',
//        'min:3',
//        'between:3,10',
//        'required_with:name'
//    ],
    'name' => 'required',
    'email' => 'required|email|min:3|between:3,10|required_with:name'
];
$message = [
    'name.required' => 'ban phai nhap ten',
    'email.required'=> 'ban phai nhap email'
];
require(__DIR__ . '/ValidateService.php');
// init data

 foreach ($rules as $filedname => $ruleArray) {
    $rules[$filedname]= explode("|",$ruleArray );
}
//print_r($rules);
$validate = new ValidateService($dataForm);
$validate->setMessage($message);
$validate->setRules($rules);
$validate->validate();
echo "<pre>";
print_r($validate->getErrors());
<?php

$errors = [];
$inputs = [];

$cleanEmail = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
$cleanPassword = filter_input(INPUT_POST,'password',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

//validate Email
$inputs['email'] = $cleanEmail;
if($cleanEmail){
    $email = filter_var($cleanEmail,FILTER_VALIDATE_EMAIL);
    $email || $errors['email'] = "Format email salah";
}else $errors['email'] = 'Email harus diisi';

//validate password
if($cleanPassword){
    $password = trim($cleanPassword);
    $password !== '' || $errors['password'] = "Password harus diisi";
}else $errors['password'] = 'Password harus diisi';

if(sizeof($errors)>0){
    require_once __DIR__."/get.php";
    exit();
}
//check email=admin@gmail.com dan password = admin
$check = ($email === 'admin@gmail.com' && $password === 'admin');

if(!$check){
    $errors['login'] = 'username atau password salah';
    require_once __DIR__."/get.php";
} else echo "Berhasil login";



<?php

require_once __DIR__."/sanitize.php";

$errors = [];

//Check exist email and password
if(!filter_has_var(INPUT_POST,'email')){
    $errors['email'] = 'Email harus diisi';
}

if(!filter_has_var(INPUT_POST,'password')){
    $errors['password'] = 'Password harus diisi';
}

if(sizeof($errors)>0){
    require_once __DIR__."/get.php";
    exit();
}

$data = sanitize($_POST,['email'=>'email','password'=>'string']);

extract($data);

if($email === '') $errors['email'] = 'Email harus diisi';
if($password === '') $errors['password'] = 'Password harus diisi';

if(sizeof($errors)>0){
    $inputs['email'] = $email;
    require_once __DIR__."/get.php";
    exit();
}
?>
<h2>Berhasil di sanitize</h2>
<h5>Email: <?= $email ?></h5>
<h5>Password: <?= $password ?> </h5>

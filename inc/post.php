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

if(!filter_has_var(INPUT_POST,'confPassword')){
    $errors['confPassword'] = 'Confirm password harus diisi';
}

if(sizeof($errors)>0){
    require_once __DIR__."/get.php";
    exit();
}

$data = sanitize($_POST,['email'=>'email','password'=>'string','confPassword'=>'string']);

extract($data);

validate(['email'=>$email,'password'=>$password,'confPassword'=>$confPassword],['email'=>'required | email','password'=>"required | secure | same(confPassword)",'confPassword'=>"required | same(password)"],$errors);

if(sizeof($errors)>0){
    $inputs['email'] = $email;
    require_once __DIR__."/get.php";
    exit();
}
?>
<h2>Berhasil di sanitize dan validate</h2>
<h5>Email: <?= $email ?></h5>
<h5>Password: <?= $password ?> </h5>

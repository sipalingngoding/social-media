<?php


[$inputs,$errors] = filter(['email','password'],['email'=>'email;required | email','password'=>'string;required']);

if(sizeof($errors) > 0){
    flash("login",array_values($errors)[0],FLASH_ERROR);
    redirect_with('login.php',['inputs'=>$inputs]);
}

extract($inputs);

$user = find_by_email($email);

if(!$user) redirect_with_message('login.php','email atau password salah');

$check_password = password_verify($password,$user['password']);

if(!$check_password) redirect_with_message('login.php','email atau password salah');

setcookie('user',$user['user_id']."_".$user['username'],time()+3600,'/');

redirect('index.php');

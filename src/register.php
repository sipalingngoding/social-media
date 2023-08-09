<?php

[$inputs,$errors] = filter(['username','email','password','confPassword','agree'],['username'=>'string; required| between(8,15)','email'=>'email; required | email','password'=>'string;required | secure | same(confPassword)','confPassword'=>'string; required | same(password)','agree'=>'string; required']);

// Flash
//if(sizeof($errors)>0){
//    redirect_with_message('register.php',array_values($errors)[0]);
//}

if(sizeof($errors)>0){
    $css = [];
    $keysError = array_keys($errors);
    foreach ($keysError as $key=>$value) $css[$value] = 'error';
    view('register',['inputs'=>$inputs,'errors'=>$errors,'css'=>$css]);
    exit();
}

//Create user
try {
    extract($inputs);
    create($username,$email,$password);
    redirect_with_message('login.php','Berhasil register. Silahkan Login',FLASH_SUCCESS);
}catch (Exception $exception)
{
    redirect_with_message('register.php',$exception->getMessage());
}



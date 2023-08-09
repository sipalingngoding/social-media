<?php

[$inputs,$errors] = filter(['email','password','confPassword'],['email'=>'email; required | email','password'=>'string; required | secure | same(confPassword)','confPassword'=>'string; required | same(password)']);

if(sizeof($errors)>0){
    $error = array_values($errors)[0];
    require_once __DIR__."/get.php";
    exit();
}
extract($inputs);
?>
<h2>Berhasil di sanitize dan validate</h2>
<h5>Email: <?= $email ?></h5>
<h5>Password: <?= $password ?> </h5>

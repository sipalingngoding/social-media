<?php

[$inputs,$errors] = filter(['username','email'],['username'=>'string; required | between(8,15)','email'=>'email;required | email']);

$upload = upload('photo',1.5,['image/jpg','image/png','image/jpeg'],$errors);

if(sizeof($errors)>0) {
    if($upload) {
        unlink(__DIR__."/../../public/uploads/$upload");
        unset($_SESSION[FLASH]['upload']);
    }
    redirect_with_message('profile.php',array_values($errors)[0]);
}

$inputs['password'] = $user['password'];
$inputs['user_id'] = $user['user_id'];
$inputs['photo'] = $upload ? : $user['photo'];
extract($inputs);
try {
    update($username,$email,$password,$user_id,$photo);
    setcookie('user',$user_id."_".$username,time()+3600,'/');
    redirect_with_message('profile.php','Berhasil diupdate',FLASH_SUCCESS);
}catch (Exception $exception){
    redirect_with_message('profile.php',$exception->getMessage());
}


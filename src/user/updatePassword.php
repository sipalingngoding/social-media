<?php

[$inputs,$errors] = filter(['oldPassword','newPassword'],['oldPassword'=>'string;required','newPassword'=>'string; required | secure']);

if(sizeof($errors)>0) redirect_with_message('profile.php',array_values($errors)[0]);

extract($inputs);

try {
    $verifyPassword = password_verify($oldPassword,$user['password']);
    if(!$verifyPassword) throw new Exception('Old Password salah');
    update($user['username'],$user['email'],password_hash($newPassword,PASSWORD_DEFAULT),$user['user_id'],$user['photo']);
    redirect_with_message('profile.php','Berhasil update password',FLASH_SUCCESS);
}catch (Exception $exception)
{
    redirect_with_message('profile.php',$exception->getMessage());
}

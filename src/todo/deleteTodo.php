<?php

[$inputs,$errors] = filter(['todo_id'],['todo_id'=>'string;required'],INPUT_GET);

if(sizeof($errors) > 0) redirect_with_message('index.php',array_values($errors)[0]);

//die();
try {
    deleteTodo($inputs['todo_id'],$user['user_id']);
    redirect_with_message('index.php','Berhasil dihapus',FLASH_SUCCESS);
}catch (Exception $exception)
{
    redirect_with_message('index.php',$exception->getMessage());
}


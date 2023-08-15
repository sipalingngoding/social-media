<?php


[$inputs,$errors] = filter(['todo','time'],['todo'=>'string; required | between(8,255)','time'=>'string; required']);

if(sizeof($errors) > 0) redirect_with_message('addtodo.php',array_values($errors)[0]);

extract($inputs);

try {
    createTodo($todo,$time,$user['user_id']);
    redirect_with_message('addtodo.php','Todo berhasil ditambahkan',FLASH_SUCCESS);
}catch (Exception $exception)
{
    redirect_with_message('addtodo.php',$exception->getMessage());
}


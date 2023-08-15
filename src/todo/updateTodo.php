<?php

[$inputs,$errors] = filter(['todo','time'],['todo'=>'string;required | between(8,255)','time'=>'string;required']);


if(sizeof($errors) > 0) redirect_with_message("updatetodo.php?todo_id=".$inputsGet['todo_id'],array_values($errors)[0]);

try {
    updateTodo($inputs['todo'],$inputs['time'],$todo['status'],$todo['todo_id']);
    redirect_with_message('updatetodo.php?todo_id='.$inputsGet['todo_id'],'Berhasil di update',FLASH_SUCCESS);
}catch (Exception $exception)
{
    redirect_with_message("updatetodo.php?todo_id=".$inputsGet['todo_id'],$exception->getMessage());
}

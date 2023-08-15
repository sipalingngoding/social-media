<?php

require_once __DIR__."/../src/bootstrap.php";

must_login();

$user = current_user();

[$inputsGet,$errors] = filter(['todo_id'],['todo_id'=>'string; required'],INPUT_GET);
if(!findOneTodo($inputsGet['todo_id'])) $errors['notFound'] = 'Todo tidak ditemukan';
if(!findOneTodoUser($inputsGet['todo_id'],$user['user_id'])) $errors['access'] = 'Todo bukan milik anda';

if(sizeof($errors) > 0) redirect_with_message('index.php',array_values($errors)[0]);

$todo = findOneTodo($inputsGet['todo_id']);
if($todo['status'] !== 'no') redirect_with_message('index.php','Anda tidak dapat mengedit todo ini');

view('header',['title'=>'Update Todo']);

if(is_get_request()){
    if(filter_has_var(INPUT_GET,'status')){
        [$inputs,$errors] = filter(['status'],['status'=>'string;continue'],INPUT_GET);
        if($inputs['status'] === 'yes'){
            $todo['status'] = 'yes';
            try {
                updateTodo($todo['todo'],preg_replace("/ /",'T',$todo['time']),'yes',$todo['todo_id']);
                redirect_with_message('index.php','Sudah dilakukan',FLASH_SUCCESS);
            }catch (Exception $exception){
                redirect_with_message('index.php',$exception->getMessage());
            }
        }
    }
    view('todo/updateTodo',['todo'=>$todo]);
}elseif (is_post_request()){
    require_once __DIR__."/../src/todo/updateTodo.php";
}

view('footer');

<?php

require_once __DIR__."/../src/bootstrap.php";

must_login();

$user = current_user();

[$inputs,$errors] = filter(['status'],['status'=>'string;continue'],INPUT_GET);

$todoList = filterStatusTodo($inputs['status'],$user['user_id']);

if(is_get_request()){
    require_once __DIR__."/../src/ajax/todolist.php";
}

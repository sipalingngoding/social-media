<?php

require_once __DIR__."/../src/bootstrap.php";
must_login();

$user = current_user();

[$inputs,$errors] = filter(['keyword'],['keyword'=>'string;continue'],INPUT_GET);

$todoList = searchTodo($inputs['keyword'],$user['user_id']);

if(is_get_request()){
    require_once __DIR__."/../src/ajax/todolist.php";
}

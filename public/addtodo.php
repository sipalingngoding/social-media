<?php

require_once __DIR__."/../src/bootstrap.php";

must_login();
$user = current_user();

view('header',['title'=>'AddTodo']);
if(is_get_request()){
    view('todo/addtodo');
}elseif (is_post_request()){
    require_once __DIR__."/../src/todo/addtodo.php";
}

view('footer');

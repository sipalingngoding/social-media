<?php

require_once __DIR__."/../src/bootstrap.php";

must_login();

$user = current_user();
$todoList = findAllTodo($user['user_id']);

view('header',['title'=>'Home']);

view('index',['user'=>$user,'todoList'=>$todoList]);

view('footer',['js'=>'index']);


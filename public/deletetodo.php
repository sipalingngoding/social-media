<?php

require_once __DIR__."/../src/bootstrap.php";

must_login();

$user = current_user();

if(is_get_request()){
    require_once __DIR__."/../src/todo/deleteTodo.php";
}

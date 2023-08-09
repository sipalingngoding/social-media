<?php


require_once __DIR__."/../src/bootstrap.php";

view("header",['title'=>'Login','css'=>'login']);

if(is_get_request()){
    view("login");
}elseif (is_post_request()){
    require_once __DIR__."/../src/login.php";
}

view("footer");

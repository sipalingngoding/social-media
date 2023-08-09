<?php

require_once __DIR__."/../src/bootstrap.php";

not_login();
view("header",['title'=>'Register','css'=>'register']);

if(is_get_request()){
    view("register");
}elseif (is_post_request()){
    require_once __DIR__."/../src/register.php";
}

view("footer");

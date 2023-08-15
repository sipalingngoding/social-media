<?php

require_once __DIR__."/../src/bootstrap.php";

must_login();

$user = current_user();

if(is_post_request()){
    require_once __DIR__."/../src/user/updatePassword.php";
}

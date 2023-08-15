<?php

require_once __DIR__ . "/../src/bootstrap.php";

view('header',['title'=>'Update Profil']);
must_login();
$user = current_user();

if(is_get_request()) view('user/update',['user'=>$user]);
elseif (is_post_request()) require_once __DIR__ . "/../src/user/updateProfile.php";

view('footer');

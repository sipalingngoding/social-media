<?php

$method = $_SERVER['REQUEST_METHOD'];

require __DIR__."/inc/header.php";

$choices = ["Email","Phone","Telegram"];

if($method === 'GET'){
    require __DIR__."/inc/get.php";
}elseif ($method  === 'POST'){
    require __DIR__."/inc/post.php";
}

require __DIR__."/inc/footer.php";

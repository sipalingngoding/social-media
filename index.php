<?php

session_start();
require_once __DIR__."/inc/flash.php";

$method = $_SERVER['REQUEST_METHOD'];
$title = "PHP Upload";
require_once __DIR__."/inc/header.php";

if($method === 'GET'){
    require_once __DIR__."/inc/get.php";
}elseif ($method === 'POST'){
    require_once __DIR__."/inc/upload.php";
}
require_once __DIR__."/inc/footer.php";

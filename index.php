<?php

$method = $_SERVER['REQUEST_METHOD'];

require __DIR__."/inc/header.php";

$pizza_toppings = [
    'pepperoni' => 0.5,
    'mushrooms' => 1,
    'onions' => 1.5,
    'sausage' => 2.5,
    'bacon' => 1.0,
];

if($method === 'GET'){
    require __DIR__."/inc/get.php";
}elseif ($method  === 'POST'){
    require __DIR__."/inc/post.php";
}

require __DIR__."/inc/footer.php";

<?php

$errors = [];

$agree = filter_input(INPUT_POST,'agree',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

($agree === null || $agree === '') && $errors['agree'] = "Tekan setuju dulu";
$agree === 'yes' || $errors['agree'] = "Tekan setuju dulu";

if(sizeof($errors)>0){
    require_once __DIR__."/get.php";
    exit();
}
echo "Terima kasih sudah bergabung";



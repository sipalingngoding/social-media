<?php

global $colors;

$choice = filter_input(INPUT_POST,'color',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if(!in_array($choice,$colors)){
    $error = "Harap dipilih";
    require_once __DIR__."/get.php";
    exit();
}

?>
<h3>Anda memilihi warna <?= $choice ?></h3>

<?php

global $choices;

$choice = filter_input(INPUT_POST,'choice',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if(!in_array($choice,$choices)){
    $error = "Harap dipilih";
    require_once __DIR__."/get.php";
    exit();
}

?>
<h3>Terima kasih sudah memilihi <?= $choice ?></h3>


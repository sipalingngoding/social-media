<?php

session_start();
require_once __DIR__."/inc/flash.php";

flash("nama","Diory",FLASH_INFO);
flash("error","Saya ingin kaya",FLASH_ERROR);

$title = "Page1";

require_once __DIR__."/inc/header.php";

echo "<h2>Page 1</h2>";

echo "<a href='page2.php'>Page 2</a>";


require_once __DIR__."/inc/footer.php";



<?php

session_start();
require_once __DIR__."/inc/flash.php";

flash();

$title = "Page2";

require_once __DIR__."/inc/header.php";

echo "<h2>Page 2</h2>";

echo "<a href='page1.php'>Page 1</a>";


require_once __DIR__."/inc/footer.php";


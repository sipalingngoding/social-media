<?php

require_once __DIR__."/../src/bootstrap.php";

must_login();

$user = current_user();

view('header',['title'=>'Home']);

?>

<h1>Hello <?= $user['username'] ?></h1>

<a href="logout.php" class="btn btn-outline-danger">logout</a>

<?php view('footer');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? "" ?></title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <?php if(isset($css)) { ?>
        <link rel="stylesheet" href="/css/<?= $css ?>.css">
    <?php } ?>
</head>
<body>

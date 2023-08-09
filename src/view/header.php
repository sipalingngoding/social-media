<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="<?php isset($css) ? print "css/$css.css" : print "" ?>">
    <title><?= $title ?? "" ?></title>
</head>
<body class="center">

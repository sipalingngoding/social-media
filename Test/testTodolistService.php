<?php


use Repository\TodolistRepository;
use Service\TodolistService;

require_once __DIR__."/../Model/Todo.php";
require_once __DIR__."/../Repository/TodolistRepository.php";
require_once __DIR__."/../Service/TodolistService.php";


global $todoList;

$todoListService= new TodolistService(new TodolistRepository($todoList));

var_dump($todoListService->findAll());

//Add
try {
    $todoListService->add("Belajar Javascript");
}catch (Exception $exception)
{
    echo $exception->getMessage().PHP_EOL;
}

var_dump($todoListService->findAll());

//Delete

try {
    $todoListService->delete(3);
}catch (Exception $exception)
{
    echo $exception->getMessage().PHP_EOL;
}

var_dump($todoListService->findAll());

//Update

try {
    $todoListService->update(2,"Makan Siang");
}catch (Exception $exception)
{
    echo $exception->getMessage().PHP_EOL;
}


var_dump($todoListService->findAll());

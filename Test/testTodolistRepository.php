<?php

use Model\Todo;
use Repository\TodolistRepository;
use function Function\connection;

require_once __DIR__."/../Function/connection.php";
require_once __DIR__."/../Model/Todo.php";
require_once __DIR__."/../Repository/TodolistRepository.php";

$todoListRepository = new TodolistRepository(connection());

//FindAll

var_dump($todoListRepository->findAll());

//Add
//$todoNew = new Todo();
//$todoNew->setTodo("Belajar Javascript");
//$todoListRepository->add($todoNew);
//
//var_dump($todoListRepository->findAll());

//Delete
//$todoDelete = new Todo();
//$todoDelete->setNo(3);
//$todoListRepository->delete($todoDelete);
//
//var_dump($todoListRepository->findAll());

//Update
$todoUpdate = new Todo();
$todoUpdate->setTodo("Belajar Javascript");
$todoUpdate->setNo(3);
//$todoListRepository->update($todoUpdate);
//
//var_dump($todoListRepository->findAll());

var_dump($todoListRepository->checkTodo($todoUpdate));

<?php

use Model\Todo;
use Repository\TodolistRepository;

require_once __DIR__."/../Data/todoList.php";
require_once __DIR__."/../Model/Todo.php";
require_once __DIR__."/../Repository/TodolistRepository.php";


global $todoList;

$todoListRepository = new TodolistRepository($todoList);

//FindAll

var_dump($todoListRepository->findAll());

//Add
$todoNew = new Todo();
$todoNew->setTodo("Belajar Lagi");
$todoListRepository->add($todoNew);

var_dump($todoListRepository->findAll());

//Delete
$todoDelete = new Todo();
$todoDelete->setNo(0);
$todoListRepository->delete($todoDelete);

var_dump($todoListRepository->findAll());

//Update
$todoUpdate = new Todo();
$todoUpdate->setTodo("Belajar Javascript");
$todoUpdate->setNo(2);
$todoListRepository->update($todoUpdate);

var_dump($todoListRepository->findAll());

var_dump($todoListRepository->checkTodo($todoUpdate));

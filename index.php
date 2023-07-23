<?php

use View\TodolistView;

require_once __DIR__."/Data/todoList.php";
require_once __DIR__."/Function/input.php";
require_once __DIR__."/Model/Todo.php";
require_once __DIR__."/Model/Todo.php";
require_once __DIR__."/Repository/TodolistRepository.php";
require_once __DIR__."/Service/TodolistService.php";
require_once __DIR__."/View/TodolistView.php";

global $todoList;

$todoListView = new TodolistView($todoList);

$todoListView->runApp();

<?php

require_once "../Data/todoList.php";
require_once "../Logic/add.php";
require_once "../Logic/show.php";

echo "Before".PHP_EOL;
showTodolist();

var_dump(addTodolist("Istirahat"));
echo "After".PHP_EOL;

showTodolist();

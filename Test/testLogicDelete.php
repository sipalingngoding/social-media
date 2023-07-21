<?php


require_once "../Data/todoList.php";
require_once "../Logic/delete.php";
require_once "../Logic/show.php";

echo "Sebelum\n";
showTodolist();

var_dump(deleteTodolist(2));
echo "Sesudan\n";
showTodolist();

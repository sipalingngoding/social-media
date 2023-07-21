<?php


require_once "../Data/todoList.php";
require_once "../Logic/update.php";
require_once "../Logic/show.php";

echo "Sebelum\n";
showTodolist();

var_dump(updateTodolist("Makan Pagi",2));
echo "Sesudan\n";
showTodolist();

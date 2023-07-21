<?php


function updateTodolist(string $todo,int $no):bool
{
    global $todoList;
    if ($no<=0 || $no>sizeof($todoList)) return false;
    array_splice($todoList,$no-1,1,$todo);
    return true;
}

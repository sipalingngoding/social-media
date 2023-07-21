<?php

function addTodolist(string $todo):bool
{
    global $todoList;
    $todoList[] = $todo;
    if($todo==='') return false;
    return true;
}

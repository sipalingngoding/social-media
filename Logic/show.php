<?php


function showTodolist():void
{
    global $todoList;
    foreach ($todoList as $key=>$value)
    {
        echo ($key+1).". $value".PHP_EOL;
    }
}

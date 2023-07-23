<?php


namespace Repository;

use Model\Todo;

class TodolistRepository
{
    private array $todoList;
    public function __construct(array $todoList)
    {
        $this->todoList = $todoList;
    }
    public function findAll():array
    {
        return $this->todoList;
    }

    public function add(Todo $todo):void
    {
        $this->todoList[] = $todo->getTodo();
    }

    public function delete(Todo $todo):void
    {
        array_splice($this->todoList,$todo->getNo(),1);
    }

    public function update(Todo $todo):void
    {
        array_splice($this->todoList,$todo->getNo(),1,$todo->getTodo());
    }

    public function checkTodo(Todo $todo):bool
    {
        return array_key_exists($todo->getNo(),$this->todoList);
    }
}

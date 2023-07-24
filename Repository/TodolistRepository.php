<?php


namespace Repository;

use Model\Todo;

class TodolistRepository
{
    private \PDO $pdo;
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function findAll():array
    {
        $PDOStatement = $this->pdo->prepare("SELECT * FROM todolist");
        $PDOStatement->execute();
        return $PDOStatement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function add(Todo $todo):void
    {
        $PDOStatement = $this->pdo->prepare("INSERT INTO todolist(todo) VALUES (?)");
        $PDOStatement->execute([$todo->getTodo()]);
    }

    public function delete(Todo $todo):void
    {
        $PDOStatement = $this->pdo->prepare("DELETE FROM todolist WHERE id=?");
        $PDOStatement->execute([$todo->getNo()]);
    }

    public function update(Todo $todo):void
    {
        $PDOStatement = $this->pdo->prepare("UPDATE todolist SET todo=? WHERE id=?");
        $PDOStatement->execute([$todo->getTodo(),$todo->getNo()]);
    }

    public function checkTodo(Todo $todo):bool
    {
        $PDOStatement = $this->pdo->prepare("SELECT * FROM todolist WHERE id=?");
        $PDOStatement->execute([$todo->getNo()]);
        return (bool)$PDOStatement->fetch(\PDO::FETCH_ASSOC);
    }
}

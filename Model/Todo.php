<?php

namespace Model;

class Todo
{
    private string $todo;
    private int $no;

    public function getNo(): int
    {
        return $this->no;
    }

    public function setNo(int $no): void
    {
        $this->no = $no;
    }
    public function getTodo(): string
    {
        return $this->todo;
    }
    public function setTodo(string $todo): void
    {
        $this->todo = $todo;
    }
}

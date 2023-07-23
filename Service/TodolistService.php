<?php

namespace Service;

use Model\Todo;
use Repository\TodolistRepository;

class TodolistService
{
    private TodolistRepository $todolistRepository;
    public function __construct(TodolistRepository $todolistRepository)
    {
        $this->todolistRepository = $todolistRepository;
    }

    public function findAll():array
    {
        return $this->todolistRepository->findAll();
    }

    /**
     * @throws \Exception
     */
    public function add(string $todo):void
    {
        if(trim($todo) === '') throw new \Exception("Gagal ditambahkan, todo tidak boleh kosong");
        $todoNew = new Todo();
        $todoNew->setTodo($todo);
        $this->todolistRepository->add($todoNew);
    }

    /**
     * @throws \Exception
     */
    public function delete(int $no):void
    {
        $todoDelete = new Todo();
        $todoDelete->setNo($no);
        if(!$this->todolistRepository->checkTodo($todoDelete)) throw new \Exception("Todo tidak ditemukan, Periksa no todo anda");
        $this->todolistRepository->delete($todoDelete);
    }

    /**
     * @throws \Exception
     */
    public function update(int $no, string $todo):void
    {
        $todoUpdate = new Todo();
        $todoUpdate->setNo($no);
        $todoUpdate->setTodo($todo);
        if(!$this->todolistRepository->checkTodo($todoUpdate)) throw new \Exception("Todo tidak ditemukan, Periksa no todo anda");
        if(trim($todoUpdate->getTodo()) === '') throw new \Exception("Todo gagal diupdate. Todo tidak boleh kosong");
        $this->todolistRepository->update($todoUpdate);
    }

}

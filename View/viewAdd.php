<?php

function viewAddTodolist():void
{
    echo "Add Todolist\n";
    $todo = input("Masukan todo");
    $result = addTodolist($todo);
    if($result){
        echo "Berhasil ditambahkan\n";
        return;
    }
    echo "Gagal ditambahkan, todo tidak boleh kosong\n";
}

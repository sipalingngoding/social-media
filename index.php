<?php

require_once "Data/todoList.php";
require_once "Function/input.php";
require_once "Logic/add.php";
require_once "Logic/delete.php";
require_once "Logic/show.php";
require_once "Logic/update.php";
require_once "View/viewShow.php";
require_once "View/viewAdd.php";
require_once "View/viewDelete.php";
require_once "View/viewUpdate.php";

echo "----------Aplikasi Todolist------------\n";

while (true) {
    echo "Perhatikan pilihan dibawah ini\n";
    echo "1. Show Todolist\n";
    echo "2. Add Todolist\n";
    echo "3. Delete Todolist\n";
    echo "4. Update Todolist\n";
    $pilihan = input("Masukan pilihan anda");
    switch ($pilihan){
        case "1":
            viewShowTodolist();
            break;
        case "2":
            viewAddTodolist();
            break;
        case "3":
            viewDeleteTodolist();
            break;
        case "4":
            viewUpdateTodolist();
            break;
        default:
            echo "Inputan anda salah\n";
            break;
    }
    $check = input("Lanjut?? Y/N");
    if(strtoupper($check) === 'N') break;
}

echo "-------------Selesai-----------\n";

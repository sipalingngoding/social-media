<?php


function viewUpdateTodolist():void
{
    echo "Update Todolist\n";
    showTodolist();
    $todo = input("Masukan todo update");
    if($todo === '') {
        echo "Todo tidak boleh kosong\n";
    }
    $no = input("Masukan no todo");
    $result = updateTodolist($todo,$no);
    if(!$result){
        echo "Gagal diupdated, perhatikan todo dan no yang anda masukan\n";
        return;
    }
    echo "Berhasil diupdated\n";
}

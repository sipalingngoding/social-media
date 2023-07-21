<?php


function viewDeleteTodolist():void
{
    echo "Delete Todolist\n";
    showTodolist();
    $no = input("Masukan no todo yang ingin dihapus");
    $result = deleteTodolist($no);
    if(!$result){
        echo "Gagal dihapus, perhatikan no yang anda masukan!!\n";
        return;
    }
    echo "Berhasil dihapus\n";
}

<?php

try {
    $pdo = connection();
}catch (PDOException $exception){
    die($exception->getMessage());
}


/**
 * @throws Exception
 */
function createTodo(string $todo, string $time,string $user_id):void
{
    global $pdo;
    try {
        validateTodoTime($time);
        $statement = $pdo->prepare("INSERT INTO todolist(todo_id,todo,time,created_at,updated_at,user_id) VALUES (?,?,?,?,?,?)");
        $created_at = date("Y-m-d H:i:s");
        $statement->execute([uniqid(),$todo,$time,$created_at,$created_at,$user_id]);
    }catch (Exception $exception){
        throw new Exception($exception->getMessage());
    }
}

/**
 * @throws Exception
 */
function updateTodo(string $todo, string $time, string $status ,string $todo_id):void
{
    global $pdo;
    try {
        validateTodoTime($time);
        $statement = $pdo->prepare("UPDATE todolist SET todo = ?, time = ?, status = ? , updated_at = ? WHERE todo_id = ?");
        $statement->execute([$todo,$time,$status,date("Y-m-d H:i:s"),$todo_id]);
    }catch (Exception $exception){
        throw new Exception($exception->getMessage());
    }
}

function findAllTodo(string $user_id):array
{
    global $pdo;
    $statement = $pdo->prepare("UPDATE todolist SET status = 'false'WHERE time < NOW() AND status <> 'yes'");
    $statement->execute();
    $statement = $pdo->prepare('SELECT * FROM todolist WHERE user_id = ? ORDER BY time ASC');
    $statement->execute([$user_id]);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function findOneTodoUser(string $todo_id,string $user_id):?array
{
    global $pdo;
    $statement = $pdo->prepare('SELECT * FROM todolist WHERE todo_id = ? AND user_id = ?');
    $statement->execute([$todo_id,$user_id]);
    return $statement->fetch(PDO::FETCH_ASSOC) ? : null;
}

function findOneTodo(string $todo_id):?array
{
    global $pdo;
    $statement = $pdo->prepare('SELECT * FROM todolist WHERE todo_id = ?');
    $statement->execute([$todo_id]);
    return $statement->fetch(PDO::FETCH_ASSOC) ? : null;
}

/**
 * @throws Exception
 */
function deleteTodo(string $todo_id, string $user_id):void
{
    global $pdo;
    try {
        validateTodo($todo_id,$user_id);
        $statement = $pdo->prepare("DELETE FROM todolist WHERE todo_id = ?");
        $statement->execute([$todo_id]);
    }catch (Exception $exception)
    {
        throw new Exception($exception->getMessage());
    }
}

/**
 * @throws Exception
 */
function validateTodo(string $todo_id, string $user_id):void
{
    if(!findOneTodo($todo_id)) throw new Exception(('Todo tidak ditemukan'));
    if(!findOneTodoUser($todo_id,$user_id)) throw new Exception('Todo bukan milik anda');
}


/**
 * @throws Exception
 */
function validateTodoTime(string $time):string
{
    if(!str_contains($time,"T")) throw new Exception('Format time salah');

    $timePost = timestamp($time);
    if($timePost < time()) throw new Exception('Waktu todo tidak sesuai');

    return date("Y-m-d H:i:s",$timePost);
}

function searchTodo(string $keyword, string $user_id):array
{
    global $pdo;
    $pattern = '%'.$keyword.'%';
    $statement = $pdo->prepare("SELECT * FROM todolist WHERE todo_id LIKE :pattern OR todo LIKE :pattern OR time LIKE :pattern ORDER BY time");
    $statement->execute([':pattern'=>$pattern,':user_id'=>$user_id]);
    $todoList =  $statement->fetchAll(PDO::FETCH_ASSOC);
    $result = [];
    foreach ($todoList as $todo){
        if($todo['user_id']===$user_id) $result[] = $todo;
    }
    return $result;
}

function filterStatusTodo(string $status, string $user_id):array
{
    global $pdo;
    $pattern = "%".$status."%";
    $statement = $pdo->prepare('SELECT * FROM todolist WHERE status LIKE :pattern ORDER BY time');
    $statement->execute([":pattern"=>$pattern]);
    return array_filter($statement->fetchAll(PDO::FETCH_ASSOC),fn($todo) =>$todo['user_id'] === $user_id);
}

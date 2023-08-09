<?php

use JetBrains\PhpStorm\NoReturn;

$pdo = connection();
/**
 * @throws Exception
 */
function create(string $username, string $email, string $password):void
{
    global $pdo;
    try {
        $check_username = find_by_username($username);
        if($check_username) throw new PDOException("Username telah digunakan");
        $check_email = find_by_email($email);
        if($check_email) throw new PDOException("Email telah digunakan");
        $hash_password = password_hash($password,PASSWORD_DEFAULT);
        $created_at = date("Y-m-d H:i:s");
        // save
        $statement = $pdo->prepare("INSERT INTO users(user_id,username,email,password,created_at,updated_at) VALUES (?,?,?,?,?,?)");
        $statement->execute([uniqid(),$username,$email,$hash_password,$created_at,$created_at]);
    }catch (Exception $exception)
    {
        throw new Exception($exception->getMessage());
    }
}

function find_by_username(string $username):?array
{
    global $pdo;
    $statement = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $statement->execute([$username]);
    return $statement->fetch(PDO::FETCH_ASSOC) ? : null;
}

function find_by_email(string $email):?array
{
    global $pdo;
    $statement = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $statement->execute([$email]);
    return $statement->fetch(PDO::FETCH_ASSOC) ? : null;
}

function find_by_userid(string $userid):?array
{
    global $pdo;
    $statement = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
    $statement->execute([$userid]);
    return $statement->fetch(PDO::FETCH_ASSOC) ? : null;
}

function must_login():void
{
    $user = $_COOKIE['user'] ?? null;
    if(!$user) redirect_with_message('login.php','Silahkan login');
    if(!str_contains($user,'_')) redirect_with_message('login.php','Silahkan login');
    [$userid,$username] = explode("_",$user);
    $check = find_by_userid($userid) && find_by_username($username);
    if(!$check) redirect_with_message('login.php','Silahkan login');
}

function not_login():void
{
    $user = $_COOKIE['user'] ?? null;
    if(!$user) return;
    if(!str_contains($user,'_')) return;
    [$userid,$username] = explode("_",$user);
    $check = find_by_userid($userid) && find_by_username($username);
    if(!$check) return;
    redirect("index.php");
}

#[NoReturn] function logout():void
{
    setcookie('user','',1,'/');
    redirect_with_message('login.php','Berhasil logout',FLASH_SUCCESS);
}

function current_user():array
{
    $user = explode('_',$_COOKIE['user']);
    return find_by_userid($user[0]);
}

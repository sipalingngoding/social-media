<?php

use JetBrains\PhpStorm\NoReturn;

try {
    $pdo = connection();
}catch (PDOException $exception){
    die($exception->getMessage());
}
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

/**
 * @throws Exception
 */
function update(string $username, string $email, string $password, string $userid, ?string $photo):void
{
    global $pdo;
    try {
        $user = find_by_userid($userid);
        if($user['username'] !== $username){
            find_by_username($username) && throw new Exception('Username telah digunakan');
        }
        if($user['email'] !== $email){
            find_by_email($email) && throw new Exception('Email telah digunakan');
        }
        $statement = $pdo->prepare("UPDATE users SET username = ?, email = ?, password = ?, updated_at = ?, photo = ? WHERE user_id = ?");
        $statement->execute([$username,$email,$password,date("Y-m-d H:i:s"),$photo,$userid]);
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

function is_login():bool
{
    $user = $_COOKIE['user'] ?? null;
    if(!$user) return false;
    if(!str_contains($user,'_')) return false;
    [$userid,$username] = explode("_",$user);
    return find_by_userid($userid) && find_by_username($username);
}

function must_login():void
{
    if(!is_login()) redirect_with_message('login.php','Silahkan login');
}

function not_login():void
{
    if(is_login()) redirect("index.php");
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

<?php

$pdo = connection() ? : die('Gagal connect');
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

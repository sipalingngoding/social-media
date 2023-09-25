<?php

namespace SipalingNgoding\MVC\repository;

use SipalingNgoding\MVC\model\User;

class UserRepository
{
    private \PDO $conn;

    public function __construct(\PDO $conn)
    {
        $this->conn = $conn;
    }

    public function findAll():array
    {
        $PDOStatement = $this->conn->prepare("SELECT * FROM users");
        $PDOStatement->execute();
        return $PDOStatement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findById($id): ?array
    {
        $PDOStatement = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $PDOStatement->execute([$id]);
        return $PDOStatement->fetch(\PDO::FETCH_ASSOC) ? : null;
    }

    public function findByEmail(string $email): ?array
    {
        $PDOStatement = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $PDOStatement->execute([$email]);
        return $PDOStatement->fetch(\PDO::FETCH_ASSOC) ? : null;
    }

    public function insert(User $user) : int
    {
        $PDOStatement = $this->conn->prepare("INSERT INTO users(email,password,full_name,address)VALUES (?,?,?,?)");
        $PDOStatement->execute([$user->email,$user->password,$user->full_name,$user->address]);
        return $this->conn->lastInsertId();
    }

    public function update(User $user, int $userId) : true
    {
        $PDOStatement = $this->conn->prepare("UPDATE users SET email= ?, password=?, full_name =?,address = ?, photo = ? WHERE id=?");
        $PDOStatement->execute([$user->email,$user->password,$user->full_name,$user->address, $user->photo, $userId]);
        return true;
    }

    public function delete($id):true
    {
        $PDOStatement = $this->conn->prepare("DELETE FROM users WHERE id =?");
        $PDOStatement->execute([$id]);
        return true;
    }

    public function deleteAll():void
    {
        $PDOStatement = $this->conn->prepare("DELETE FROM users");
        $PDOStatement->execute();
    }

    //For Testing
    public function insertUserTest():void
    {
        $this->conn->exec("INSERT INTO users(email,password,full_name,address) VALUES ('diory@gmail.com','Diory123?','Diory Pribadi Sinaga','Bandung')");

        $this->conn->exec("INSERT INTO users(email,password,full_name,address) VALUES ('budiman@gmail.com','Budiman123?','Budiman Aja','Jakarta')");
    }

    public function lastUserId() :int
    {
        $PDOStatement = $this->conn->prepare("SELECT * FROM users ORDER BY id DESC LIMIT 1");
        $PDOStatement->execute();
        return $PDOStatement->fetch(\PDO::FETCH_ASSOC)['id'];
    }

}

<?php

namespace SipalingNgoding\MVC\repository;

use SipalingNgoding\MVC\model\Photo;

class PhotoRepository
{
    private \PDO $conn;
    public function __construct(\PDO $conn)
    {
        $this->conn = $conn;
    }

    public function findAll(bool $desc):array
    {
        if($desc) $PDOStatement = $this->conn->prepare("SELECT * FROM photos ORDER BY id DESC ");
        else $PDOStatement = $this->conn->prepare("SELECT * FROM photos ORDER BY id ASC ");
        $PDOStatement->execute();
        return $PDOStatement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findAllPhotoUser(int $userId, bool $desc):array
    {
        if($desc) $PDOStatement = $this->conn->prepare("SELECT * FROM photos WHERE userId = ? ORDER BY id DESC ");
        else $PDOStatement = $this->conn->prepare("SELECT * FROM photos WHERE userId = ? ORDER BY id ASC ");
        $PDOStatement->execute([$userId]);
        return $PDOStatement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findOne($id):array | null{
        $PDOStatement = $this->conn->prepare("SELECT * FROM photos WHERE id=?");
        $PDOStatement->execute([$id]);
        return $PDOStatement->fetch(\PDO::FETCH_ASSOC) ? : null;
    }

    public function findAllNotPhotoUser(int $userId):array
    {
        $PDOStatement = $this->conn->prepare("SELECT * FROM photos WHERE userId <> ? ORDER BY id DESC ");
        $PDOStatement->execute([$userId]);
        return $PDOStatement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insert(Photo $photo):int
    {
        $PDOStatement = $this->conn->prepare("INSERT INTO photos(title,description,image,userId,createdAt,updatedAt) VALUES (?,?,?,?,?,?)");
        $PDOStatement->execute([$photo->title,$photo->description,$photo->image,$photo->userId,$photo->createdAt,$photo->updatedAt]);
        return $this->conn->lastInsertId();
    }


    public function update(Photo $photo):bool
    {
        $PDOStatement = $this->conn->prepare("UPDATE photos SET title=?, description = ?, image=?, updatedAt=? WHERE id = ?");
        $PDOStatement->execute([$photo->title,$photo->description,$photo->image,$photo->updatedAt, $photo->id]);
        return true;
    }

    public function delete(int $id):bool
    {
        $PDOStatement = $this->conn->prepare("DELETE FROM photos WHERE id = ?");
        $PDOStatement->execute([$id]);
        return true;
    }

    public function deleteAll():void
    {
        $PDOStatement = $this->conn->prepare("DELETE FROM photos");
        $PDOStatement->execute();
    }

    public function insertPhotoTest(int $userId1,int $userId2):void
    {
        $createdAt = date("Y-m-d H:i:s");
        $this->conn->exec("INSERT INTO photos(title,description,image,userId,createdAt,updatedAt) VALUES ('photoDiory','Photo Diory Keren','diory.jpg','$userId1','$createdAt','$createdAt')");
        $this->conn->exec("INSERT INTO photos(title,description,image,userId,createdAt,updatedAt) VALUES ('photoBudiman','Photo Budiman Keren','budiman.jpg','$userId2','$createdAt','$createdAt')");
    }

    public function lastPhotoId():int
    {
        $PDOStatement = $this->conn->prepare("SELECT * FROM photos ORDER BY id DESC LIMIT 1");
        $PDOStatement->execute();
        return $PDOStatement->fetch(\PDO::FETCH_ASSOC)['id'];
    }
}

<?php

namespace SipalingNgoding\MVC\repository;

use SipalingNgoding\MVC\model\Comment;

class CommentRepository
{
    private \PDO $conn;

    public function __construct(\PDO $conn)
    {
        $this->conn = $conn;
    }

    public function getAll(int $photoId):array
    {
        $PDOStatement = $this->conn->prepare("SELECT * FROM comments WHERE photoId = ?");
        $PDOStatement->execute([$photoId]);
        return $PDOStatement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById(int $id):array | null
    {
        $PDOStatement = $this->conn->prepare("SELECT * FROM comments WHERE id = ?");
        $PDOStatement->execute([$id]);
        return $PDOStatement->fetch(\PDO::FETCH_ASSOC) ? : null;
    }


    public function insert(Comment $comment):int
    {
        $PDOStatement = $this->conn->prepare('INSERT INTO comments(comment,userId,photoId,createdAt, updatedAt) VALUES (?,?,?,?,?)');
        $PDOStatement->execute([$comment->comment,$comment->userId,$comment->photoId,$comment->createdAt,$comment->updatedAt]);
        return $this->conn->lastInsertId();
    }

    public function update(Comment $comment):true
    {
        $PDOStatement = $this->conn->prepare("UPDATE comments SET comment = ?, updatedAt = ? WHERE id = ?");
        $PDOStatement->execute([$comment->comment,$comment->updatedAt,$comment->id]);
        return true;
    }

    public function delete(int $id):true
    {
        $PDOStatement = $this->conn->prepare("DELETE FROM comments WHERE id = ?");
        $PDOStatement->execute([$id]);
        return true;
    }

    public function deleteAll():void
    {
        $PDOStatement = $this->conn->prepare("DELETE FROM comments");
        $PDOStatement->execute();
    }

    public function insertCommentTest(string $comment1, int $userId1,int $photoId1,string $comment2, int $userId2,int $photoId2):void
    {
        $createdAt = date('Y-m-d H:i:s');
        $this->conn->exec("INSERT INTO comments(comment,userId,photoId,createdAt, updatedAt) VALUES ('$comment1','$userId1','$photoId1','$createdAt','$createdAt')");
        $this->conn->exec("INSERT INTO comments(comment,userId,photoId,createdAt, updatedAt) VALUES ('$comment2','$userId2','$photoId2','$createdAt','$createdAt')");
    }

    public function lastCommentId():int
    {
        $PDOStatement = $this->conn->prepare("SELECT * FROM comments ORDER BY id DESC LIMIT 1");
        $PDOStatement->execute();
        return $PDOStatement->fetch(\PDO::FETCH_ASSOC)['id'];
    }
}

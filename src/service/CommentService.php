<?php

namespace SipalingNgoding\MVC\service;

use SipalingNgoding\MVC\app\Database;
use SipalingNgoding\MVC\Exception\ClientError;
use SipalingNgoding\MVC\Exception\NotFoundError;
use SipalingNgoding\MVC\libs\Helper;
use SipalingNgoding\MVC\repository\CommentRepository;
use SipalingNgoding\MVC\repository\PhotoRepository;
use SipalingNgoding\MVC\repository\UserRepository;
use SipalingNgoding\MVC\validator\Comment;

class CommentService
{
    private CommentRepository $commentRepository;

    private PhotoRepository $photoRepository;

    private UserRepository $userRepository;
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->photoRepository = new PhotoRepository(Database::$conn);
        $this->userRepository = new UserRepository(Database::$conn);
    }

    public function getAll(int $photoId):array
    {
        $comments =  $this->commentRepository->getAll($photoId);
        for ($i = 0; $i < sizeof($comments); $i++) {
            $comments[$i]['full_name'] = $this->userRepository->findById($comments[$i]['userId'])['full_name'] ;
        }
        return $comments;
    }

    /**
     * @throws ClientError
     */
    public function add(int $userId, int $photoId):int
    {
        $photo = $this->photoRepository->findOne($photoId);
        if(!$photo) throw new NotFoundError('Photo Not Found');
        [$inputs,$errors] = Comment::validateInsertComment();
        if(sizeof($errors) > 0 ) throw new ClientError(array_values($errors)[0]);
        $createdAt = date('Y-m-d H:i:s');

        $comment = new \SipalingNgoding\MVC\model\Comment(1,$userId,$photoId,$inputs['comment'],$createdAt,$createdAt);

        return $this->commentRepository->insert($comment);
    }

    /**
     * @throws ClientError
     * @throws NotFoundError
     */
    public function update(int $commentId, int $userId):true
    {
        [$inputs,$errors] = Comment::validateInsertComment();
        if(sizeof($errors) > 0 ) throw new ClientError(array_values($errors)[0]);
        $updatedAt = date('Y-m-d H:i:s');
        $comment = $this->commentRepository->getById($commentId);
        if(!$comment) throw new NotFoundError('Comment Not Found');
        if($comment['userId'] !== $userId) throw new ClientError('Forbidden');

        $commentUpdate = new \SipalingNgoding\MVC\model\Comment($commentId,$userId,1,$inputs['comment'],'',$updatedAt);
        return $this->commentRepository->update($commentUpdate);
    }

    /**
     * @throws ClientError
     */
    public function delete(int $userId):int
    {
        [$inputs,$errors] = Helper::filter(['id'],['id'=>'int;required'],INPUT_GET);
        if(sizeof($errors) >0) throw new ClientError(array_values($errors)[0]);
        $comment = $this->commentRepository->getById($inputs['id']);
        if(!$comment) throw new NotFoundError('comment not found');
        $photo = $this->photoRepository->findOne(($comment['photoId']));

        if($comment['userId'] !== $userId && $photo['userId'] !== $userId) throw new ClientError('Forbidden');

        $this->commentRepository->delete($inputs['id']);
        return $comment['photoId'];
    }
}

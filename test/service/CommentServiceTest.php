<?php

namespace SipalingNgoding\MVC\service;

use PHPUnit\Framework\TestCase;
use SipalingNgoding\MVC\app\Database;
use SipalingNgoding\MVC\Exception\ClientError;
use SipalingNgoding\MVC\Exception\NotFoundError;
use SipalingNgoding\MVC\model\Comment;
use SipalingNgoding\MVC\repository\CommentRepository;
use SipalingNgoding\MVC\repository\PhotoRepository;
use SipalingNgoding\MVC\repository\UserRepository;

class CommentServiceTest extends TestCase
{
    private CommentService $commentService;
    private PhotoRepository $photoRepository;
    private UserRepository $userRepository;

    private CommentRepository $commentRepository;

    protected function setUp(): void
    {
        Database::getConnection();
        $this->commentService = new CommentService(new CommentRepository(Database::$conn));
        $this->photoRepository = new PhotoRepository(Database::$conn);
        $this->userRepository = new UserRepository(Database::$conn);
        $this->commentRepository = new CommentRepository(Database::$conn);

        $this->commentRepository->deleteAll();
        $this->photoRepository->deleteAll();
        $this->userRepository->deleteAll();

        $this->userRepository->insertUserTest();
        $lastUserId = $this->userRepository->lastUserId();
        $this->photoRepository->insertPhotoTest($lastUserId-1,$lastUserId);
        $lastPhotoId = $this->photoRepository->lastPhotoId();
        $this->commentRepository->insertCommentTest('Comment Photo Diory',$lastUserId-1,$lastPhotoId-1,'Comment Photo Budiman',$lastUserId,$lastPhotoId);
    }

    public function testGetAllCommentSuccess():void
    {
        $lastPhotoId = $this->photoRepository->lastPhotoId();
        $comments = $this->commentService->getAll($lastPhotoId);
        self::assertCount(1,$comments);
        self::assertSame('Comment Photo Budiman',$comments[0]['comment']);
        self::assertSame($this->userRepository->lastUserId(),$comments[0]['userId']);
        self::assertSame($this->photoRepository->lastPhotoId(),$comments[0]['photoId']);
        self::assertArrayHasKey('full_name',$comments[0]);
        self::assertSame('Budiman Aja',$comments[0]['full_name']);
    }

    public function testAddComment():void
    {
        $lastPhotoId = $this->photoRepository->lastPhotoId();
        $userId = $this->userRepository->lastUserId();

        $_POST = ['comment'=>'Comment Photo Diory'];
        $id = $this->commentService->add($userId,$lastPhotoId-1);
        self::assertSame($id,$this->commentRepository->lastCommentId());

        $comments = $this->commentService->getAll($lastPhotoId-1);
        self::assertCount(2,$comments);
    }

    public function testAddCommentFailNotFoundPhoto():void
    {
        $lastPhotoId = $this->photoRepository->lastPhotoId();
        $userId = $this->userRepository->lastUserId();

        $_POST = ['comment'=>'Comment Photo Diory'];
        self::expectException(NotFoundError::class);
        self::expectExceptionMessageMatches('/photo not found/i');
        $this->commentService->add($userId,$lastPhotoId+1);
    }

    public function testAddCommentFailInvalid():void
    {
        $lastPhotoId = $this->photoRepository->lastPhotoId();
        $userId = $this->userRepository->lastUserId();

        $_POST = ['comment'=>''];
        self::expectException(ClientError::class);
        self::expectExceptionMessageMatches('/please enter the comment/i');
        $this->commentService->add($userId,$lastPhotoId-1);
    }

    public function testUpdateSuccess():void
    {
        $lastCommentId = $this->commentRepository->lastCommentId();
        $lastUserId = $this->userRepository->lastUserId();

        $_POST = ['comment'=>'photo budiman'];
        self::assertTrue($this->commentService->update($lastCommentId,$lastUserId));
        $comment = $this->commentRepository->getById($lastCommentId);
        self::assertSame('photo budiman',$comment['comment']);
    }

    public function testUpdateFailInvalidInput():void
    {
        $lastCommentId = $this->commentRepository->lastCommentId();
        $lastUserId = $this->userRepository->lastUserId();

        $_POST = ['comment'=>''];
        self::expectException(ClientError::class);
        $this->commentService->update($lastCommentId,$lastUserId);
    }

    public function testUpdateFailNotFound():void
    {
        $lastCommentId = $this->commentRepository->lastCommentId();
        $lastUserId = $this->userRepository->lastUserId();

        $_POST = ['comment'=>'photo budiman'];
        self::expectException(NotFoundError::class);
        $this->commentService->update($lastCommentId+1,$lastUserId);
    }

    public function testUpdateFailForbidden():void
    {
        $lastCommentId = $this->commentRepository->lastCommentId();
        $lastUserId = $this->userRepository->lastUserId();

        $_POST = ['comment'=>'photo budiman'];
        self::expectException(ClientError::class);
        self::expectExceptionMessageMatches('/forbidden/i');
        $this->commentService->update($lastCommentId,$lastUserId-1);
    }

    public function testDeleteCommentSuccess():void
    {
        $lastCommentId = $this->commentRepository->lastCommentId();
        $userId = $this->userRepository->lastUserId();
        $_GET = ['id'=>$lastCommentId];
        self::assertSame($this->photoRepository->lastPhotoId(),$this->commentService->delete($userId));
        $comments = $this->commentService->getAll($this->photoRepository->lastPhotoId());

        self::assertCount(0,$comments);
    }

    public function testDeleteFailInvalidId():void
    {
        $userId = $this->userRepository->lastUserId();
        $_GET = ['id'=>'dsds'];
        self::expectException(ClientError::class);
        $this->commentService->delete($userId);
    }

    public function testDeleteFailNotFound():void
    {
        $lastCommentId = $this->commentRepository->lastCommentId();
        $userId = $this->userRepository->lastUserId();
        $_GET = ['id'=>$lastCommentId+1];
        self::expectException(NotFoundError::class);
        self::expectExceptionMessageMatches('/comment not found/i');
        $this->commentService->delete($userId);
    }
    public function testDeleteFailForbidden():void
    {
        $lastCommentId = $this->commentRepository->lastCommentId();
        $userId = $this->userRepository->lastUserId();
        $_GET = ['id'=>$lastCommentId];
        self::expectException(ClientError::class);
        self::expectExceptionMessageMatches('/forbidden/i');
        $this->commentService->delete($userId-1);
    }

    public function testDeleteSuccess():void
    {
        $comment = new Comment(1,$this->userRepository->lastUserId(),$this->photoRepository->lastPhotoId()-1,'Comment Dari Budiman untuk Diory',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
        $this->commentRepository->insert($comment);

        $lastCommentId = $this->commentRepository->lastCommentId();
        $userId = $this->userRepository->lastUserId();
        $_GET = ['id'=>$lastCommentId];
        $this->commentService->delete($userId-1);
        $comments = $this->commentService->getAll($this->photoRepository->lastPhotoId()-1);
        self::assertCount(1,$comments);
    }


}

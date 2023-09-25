<?php

namespace SipalingNgoding\MVC\repository;

use PHPUnit\Framework\TestCase;
use SipalingNgoding\MVC\app\Database;
use SipalingNgoding\MVC\model\Photo;

class PhotoRepositoryTest extends TestCase
{
    private static PhotoRepository $photoRepository;
    private static UserRepository $userRepository;

    public static function setUpBeforeClass(): void
    {
        Database::getConnection();
        self::$userRepository = new UserRepository(Database::$conn);
        self::$photoRepository = new PhotoRepository(Database::$conn);
    }

    protected function setUp(): void
    {

        self::$photoRepository->deleteAll();
        self::$userRepository->deleteAll();
        self::$userRepository->insertUserTest();
        $lastUserId = self::$userRepository->lastUserId();
        self::$photoRepository->insertPhotoTest($lastUserId-1,$lastUserId);
    }

    public function testFindAll():void
    {
        $photos = self::$photoRepository->findAll(false);
        self::assertCount(2,$photos);
        $photo = $photos[0];
        $lastUserId = self::$userRepository->lastUserId();
        //Diory
        self::assertSame('photoDiory',$photo['title']);
        self::assertSame($lastUserId-1,$photo['userId']);

        //Budiman
        self::assertSame('photoBudiman',$photos[1]['title']);
        self::assertSame($lastUserId,$photos[1]['userId']);
    }

    public function testFindPhotoSuccess():void
    {
        $lastId = self::$photoRepository->lastPhotoId();
        $photo = self::$photoRepository->findOne($lastId);
        self::assertNotNull($photo);
        self::assertSame('photoBudiman',$photo['title']);
        self::assertSame('Photo Budiman Keren',$photo['description']);
    }

    public function testFindPhotoNotFound():void
    {
        $lastId = self::$photoRepository->lastPhotoId();
        $photo = self::$photoRepository->findOne($lastId+1);
        self::assertNull($photo);
    }

    public function testInsert():void
    {
        $photo = new Photo('Diory Wisuda','Wisuda Diory Upi','wisuda.jpg',self::$userRepository->lastUserId()-1,date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
        $id = self::$photoRepository->insert($photo);
        self::assertCount(3,self::$photoRepository->findAll(false));
        self::assertSame(self::$photoRepository->lastPhotoId(),$id);
    }

    public function testDeleteSuccess():void
    {
        $lastId = self::$photoRepository->lastPhotoId();
        self::assertTrue(self::$photoRepository->delete($lastId));
        self::assertCount(1,self::$photoRepository->findAll(false));
    }
}

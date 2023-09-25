<?php

namespace SipalingNgoding\MVC\service;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SipalingNgoding\MVC\app\Database;
use SipalingNgoding\MVC\Exception\ClientError;
use SipalingNgoding\MVC\Exception\NotFoundError;
use SipalingNgoding\MVC\repository\PhotoRepository;
use SipalingNgoding\MVC\repository\UserRepository;
use SipalingNgoding\MVC\validator\Photo;

class PhotoServiceTest extends TestCase
{
    private static PhotoRepository $photoRepository;
    private static UserRepository $userRepository;

    private PhotoService $photoService;

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
        $this->photoService = new PhotoService(self::$photoRepository);
    }

    public function testGetAll():void
    {
        $photos = $this->photoService->getAll();
        self::assertCount(2,$photos);
    }

    public function testGetPhotoUser():void
    {
        $lastUserId = self::$userRepository->lastUserId();
        $photos = $this->photoService->getAllPhotoUser($lastUserId);
        self::assertCount(1,$photos);
        self::assertSame('photoBudiman',$photos[0]['title']);
    }

    public function testGetOneSuccess():void
    {
        $photo = $this->photoService->getOne(self::$photoRepository->lastPhotoId());
        self::assertNotNull($photo);
        self::assertSame('photoBudiman',$photo['title']);
    }

    public function testGetOneNotFound():void
    {
        self::expectException(NotFoundError::class);
        self::expectExceptionMessageMatches('/photo Not found/i');
        $this->photoService->getOne(self::$photoRepository->lastPhotoId()+1);
    }

    public function testAddPhotoSuccess():void
    {
        $_POST = ['title'=>'Wisuda Diory','description'=>'Wisuda UPI Diory'];
        $userId = self::$userRepository->lastUserId();
        $id = $this->photoService->add('wisuda.jpeg',$userId-1);
        self::assertSame(self::$photoRepository->lastPhotoId(),$id);
        $photos = $this->photoService->getAll(false);
        self::assertCount(3,$photos);
        self::assertSame('Wisuda Diory',$photos[2]['title']);
        self::assertSame($userId-1,$photos[2]['userId']);
    }


    public static function dataProviderAddPhoto():array
    {
        return  [
            ['','Wisuda UPI Diory'],
            ['Wisuda Diory',''],
            ['Wisu','Wisuda UPI Diory'],
            ['Wisuda Diory','Wisuda'],
        ];
    }

    #[DataProvider('dataProviderAddPhoto')]
    public function testAddPhotoFailInvalidInput($title, $description):void
    {
        $_POST = ['title'=>$title,'description'=>$description];
        $userId = self::$userRepository->lastUserId();

        self::expectException(ClientError::class);
        $this->photoService->add('wisuda.jpeg',$userId-1);
    }

    public function testUpdateSuccess():void
    {
        $lastId = self::$photoRepository->lastPhotoId();
        $lastUserId = self::$userRepository->lastUserId();
        $_GET =  ['id'=>$lastId-1];
        $_POST = ['title'=>'Photo Diory','description'=>'Photo Diory Keren'];

        self::assertTrue($this->photoService->update($lastUserId-1));

        $photo = $this->photoService->getOne($lastId-1);
        self::assertSame('Photo Diory',$photo['title']);
    }

    public function testUpdateFailInvalidId():void
    {
        $lastUserId = self::$userRepository->lastUserId();
        $_GET =  ['id'=>'dads'];
        $_POST = ['title'=>'Photo Diory','description'=>'Photo Diory Keren'];
        self::expectException(ClientError::class);
        $this->photoService->update($lastUserId-1);
    }

    public function testUpdateFailNotFound():void
    {
        $lastUserId = self::$userRepository->lastUserId();
        $lastId = self::$photoRepository->lastPhotoId();
        $_GET =  ['id'=>$lastId+1];
        $_POST = ['title'=>'Photo Diory','description'=>'Photo Diory Keren'];
        self::expectException(NotFoundError::class);
        $this->photoService->update($lastUserId-1);
    }

    public function testUpdateFailForbidden():void
    {
        $lastId = self::$photoRepository->lastPhotoId();
        $lastUserId = self::$userRepository->lastUserId();
        $_GET =  ['id'=>$lastId-1];
        $_POST = ['title'=>'Photo Diory','description'=>'Photo Diory Keren'];

        self::expectException(ClientError::class);
        self::expectExceptionMessageMatches('/cannot update this photo/i');
        $this->photoService->update($lastUserId);
    }

    public function testUpdateFailInvalidInput():void
    {
        $lastId = self::$photoRepository->lastPhotoId();
        $lastUserId = self::$userRepository->lastUserId();
        $_GET =  ['id'=>$lastId-1];
        $_POST = ['title'=>'','description'=>'Photo Diory Keren'];

        self::expectException(ClientError::class);
        self::expectExceptionMessageMatches('/please enter the title/i');
        $this->photoService->update($lastUserId-1);
    }

    public function testDeleteSuccess():void
    {
        $_GET = ['id'=>self::$photoRepository->lastPhotoId()];
        self::assertTrue($this->photoService->delete(self::$userRepository->lastUserId()));
        $photos = $this->photoService->getAll();
        self::assertCount(1,$photos);
        self::assertSame('photoDiory',$photos[0]['title']);
    }

    public function testDeleteFailNotFound():void
    {
        $_GET = ['id'=>self::$photoRepository->lastPhotoId()+1];
        self::expectException(NotFoundError::class);
        self::expectExceptionMessageMatches('/photo not found/i');
        $this->photoService->delete(self::$userRepository->lastUserId());
        $photos = $this->photoService->getAll();
        self::assertCount(2,$photos);
    }

    public function testDeleteFailForbidden():void
    {
        $_GET = ['id'=>self::$photoRepository->lastPhotoId()];
        self::expectException(ClientError::class);
        self::expectExceptionMessageMatches('/Anda tidak bisa menghapus foto ini/i');
        $this->photoService->delete(self::$userRepository->lastUserId()-1);
        $photos = $this->photoService->getAll();
        self::assertCount(2,$photos);
    }
}

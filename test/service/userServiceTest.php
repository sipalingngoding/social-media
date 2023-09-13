<?php

namespace SipalingNgoding\MVC\service;

use PHPUnit\Framework\TestCase;
use SipalingNgoding\MVC\app\Database;
use SipalingNgoding\MVC\Exception\ClientError;
use SipalingNgoding\MVC\Exception\NotFoundError;
use SipalingNgoding\MVC\libs\Tokenize;
use SipalingNgoding\MVC\repository\userRepository;
use function PHPUnit\Framework\assertSame;

class userServiceTest extends TestCase
{
    private userService $userService;
    private userRepository $userRepository;
    protected function setUp(): void
    {
        Database::getConnection();
        $userRepository = new userRepository(Database::$conn);
        $this->userRepository = $userRepository;
        $this->userService = new userService($userRepository);
        $userRepository->deleteAll();
        $userRepository->insertUserTest();
    }

    public function testGetAll():void
    {
        $users = $this->userService->getAll();
        self::assertCount(2,$users);
    }

    /**
     * @throws NotFoundError
     */
    public function testGetById():void
    {
        $lastId = $this->userRepository->lastUserId();
        $user = $this->userService->getById($lastId);
        self::assertSame('budiman@gmail.com',$user['email']);
        self::assertSame('Budiman123?',$user['password']);
        self::assertSame('Budiman Aja',$user['full_name']);
        self::assertSame('Jakarta',$user['address']);
    }

    public function testGetByIdNotFound():void
    {
        $lastId = $this->userRepository->lastUserId();
        self::expectException(NotFoundError::class);
        self::expectExceptionMessageMatches('/user not found/i');

        $this->userService->getById($lastId+1);
    }

    public function testRegisterSuccess():void
    {
        $_POST = ['email'=>'rendi@gmail.com','password'=>'Rendi123?','confPassword'=>'Rendi123?','full_name'=>'Rendi Navi','address'=>'Banjarmasin','agree'=>'yes'];
        $id = $this->userService->register();
        assertSame($id,$this->userRepository->lastUserId());
        $users = $this->userService->getAll();
        self::assertCount(3,$users);
    }

    public function testRegisterFailInvalidInput():void
    {
        $_POST = ['email'=>'','password'=>'','confPassword'=>'','full_name'=>'','address'=>'','agree'=>''];
        self::expectException(ClientError::class);
        self::expectExceptionMessageMatches('/please enter the email/i');
        $this->userService->register();
        $users = $this->userService->getAll();
        self::assertCount(2,$users);
    }

    public function testRegisterFailEmailAlreadyExist():void
    {

        $_POST = ['email'=>'diory@gmail.com','password'=>'Rendi123?','confPassword'=>'Rendi123?','full_name'=>'Rendi Navi','address'=>'Banjarmasin','agree'=>'yes'];
        self::expectException(ClientError::class);
        self::expectExceptionMessageMatches('/email already exist/i');
        $this->userService->register();
        $users = $this->userService->getAll();
        self::assertCount(2,$users);
    }

    public function testLoginSuccess():void
    {
        $_POST = ['email'=>'rendi@gmail.com','password'=>'Rendi123?','confPassword'=>'Rendi123?','full_name'=>'Rendi Navi','address'=>'Banjarmasin','agree'=>'yes'];
        $this->userService->register();
        $token = $this->userService->login();
        var_dump($token);
        self::assertNotSame('',$token);
    }

    public function testLoginFailInvalidInput():void
    {
        $_POST = ['email'=>'diory@gmail.com','password'=>''];
        self::expectException(ClientError::class);
        self::expectExceptionMessageMatches('/please enter the password/i');
        $this->userService->login();
    }

    public function testLoginFailEmailWrong():void
    {
        $_POST = ['email'=>'rendi@gmail.com','password'=>'Rendi123?','confPassword'=>'Rendi123?','full_name'=>'Rendi Navi','address'=>'Banjarmasin','agree'=>'yes'];
        $this->userService->register();
        $_POST = ['email'=>'rendi1@gmail.com','password'=>'Rendi123?'];
        self::expectException(ClientError::class);
        self::expectExceptionMessageMatches('/email or password is wrong/i');
        $this->userService->login();
    }

    public function testLoginFailPasswordWrong():void
    {
        $_POST = ['email'=>'rendi@gmail.com','password'=>'Rendi123?','confPassword'=>'Rendi123?','full_name'=>'Rendi Navi','address'=>'Banjarmasin','agree'=>'yes'];
        $this->userService->register();
        $_POST = ['email'=>'rendi@gmail.com','password'=>'salah'];
        self::expectException(ClientError::class);
        self::expectExceptionMessageMatches('/email or password is wrong/i');
        $this->userService->login();
    }

    public function testCurrentSuccess():void
    {
        $lastId = $this->userRepository->lastUserId();
        $token = Tokenize::createToken($lastId);
        $_COOKIE['cookie'] = $token;
        $user = $this->userService->current();
        self::assertNotNull($user);
    }

    public function testCurrentFailNoToken():void
    {
        $user =  $this->userService->current();
        self::assertNull($user);
    }

    public function testCurrentFailTokenInvalid():void
    {
        $lastId = $this->userRepository->lastUserId();
        $token = Tokenize::createToken($lastId);
        $_COOKIE['cookie'] = $token."salah";
        $user =  $this->userService->current();
        self::assertNull($user);
    }
}

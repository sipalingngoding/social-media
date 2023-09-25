<?php

namespace SipalingNgoding\MVC\service;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SipalingNgoding\MVC\app\Database;
use SipalingNgoding\MVC\Exception\ClientError;
use SipalingNgoding\MVC\Exception\NotFoundError;
use SipalingNgoding\MVC\libs\Tokenize;
use SipalingNgoding\MVC\repository\UserRepository;

class userServiceTest extends TestCase
{
    private UserService $userService;
    private UserRepository $userRepository;
    protected function setUp(): void
    {
        Database::getConnection();
        $userRepository = new UserRepository(Database::$conn);
        $this->userRepository = $userRepository;
        $this->userService = new UserService($userRepository);
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
        self::assertSame($id,$this->userRepository->lastUserId());
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
        self::assertNotSame('',$token);
    }

    public static function dataProviderLogin():array
    {
        return [
            ['diory@gmail.com','','mohon inputkan password'],
            ['','password','mohon inputkan email'],
            ['','','mohon inputkan email'],
            ['diory@gma','password','format email tidak valid'],
        ];
    }

    #[DataProvider('dataProviderLogin')]
    public function testLoginFailInvalidInput(string $email, string $password, string $message):void
    {
        $_POST = ['email'=>$email,'password'=>$password];
        self::expectException(ClientError::class);
        self::expectExceptionMessageMatches("/$message/i");
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

    public function testUpdate():void
    {
        $userId = $this->userRepository->lastUserId()-1;
        $_POST = ['email'=>'sinaga@gmail.com','full_name'=>'Diory Pribadi','address'=>'Bekasi'];
        self::assertTrue($this->userService->update($userId,null));
        $user = $this->userRepository->findById($userId);
        self::assertSame('sinaga@gmail.com',$user['email']);
        self::assertSame('Diory Pribadi',$user['full_name']);
        self::assertSame('Bekasi',$user['address']);
    }

    public static function dataProviderUpdate():array
    {
        return [
                    ["sinaga@gmail.com", "Diory Pribadi",""],
                    ["sinaga@gma", "Diory Pribadi","Bekasi"],
                    ["sinaga@gma", "Dior","Bekasi"],
            ];
    }

    #[DataProvider('dataProviderUpdate')]
    public function testUpdateFailInvalidInput(string $email, string $full_name, string $address):void
    {
        $userId = $this->userRepository->lastUserId()-1;
        $_POST = ['email'=>$email,'full_name'=>$full_name, 'address'=>$address];
        self::expectException(ClientError::class);
        self::assertTrue($this->userService->update($userId,null));
    }

    public function testUpdateFailNotFound():void
    {
        $userId = $this->userRepository->lastUserId()+1;
        $_POST = ['email'=>'sinaga@gmail.com','full_name'=>'Diory Pribadi','address'=>'Bekasi'];
        self::expectException(NotFoundError::class);
        $this->userService->update($userId,null);
    }

    public function testUpdatePasswordSuccess():void
    {
        $_POST = ['email'=>'rendi@gmail.com','password'=>'Rendi123?','confPassword'=>'Rendi123?','full_name'=>'Rendi Navi','address'=>'Banjarmasin','agree'=>'yes'];
        $this->userService->register();
        $userId = $this->userRepository->lastUserId();
        $_POST = ['oldPassword'=>'Rendi123?','newPassword'=>'Diory123?!'];
        self::assertTrue($this->userService->updatePassword($userId));
    }
    public function testUpdatePasswordFailInvalidInput():void
    {
        $_POST = ['email'=>'rendi@gmail.com','password'=>'Rendi123?','confPassword'=>'Rendi123?','full_name'=>'Rendi Navi','address'=>'Banjarmasin','agree'=>'yes'];
        $this->userService->register();
        $userId = $this->userRepository->lastUserId();
        $_POST = ['oldPassword'=>'Rendi123?','newPassword'=>'Diory12'];
        self::expectException(ClientError::class);
        self::expectExceptionMessageMatches('/The newPassword must have between 8 and 64 characters and contain at least one number, one upper case letter, one lower case letter and one special character/i');
        $this->userService->updatePassword($userId);
    }

    public function testUpdatePasswordFailOldPasswordWrong():void
    {
        $_POST = ['email'=>'rendi@gmail.com','password'=>'Rendi123?','confPassword'=>'Rendi123?','full_name'=>'Rendi Navi','address'=>'Banjarmasin','agree'=>'yes'];
        $this->userService->register();
        $userId = $this->userRepository->lastUserId();
        $_POST = ['oldPassword'=>'Rendi123?!','newPassword'=>'Diory123?!'];
        self::expectException(ClientError::class);
        self::expectExceptionMessageMatches('/old password is wrong/i');
        $this->userService->updatePassword($userId);
    }
}

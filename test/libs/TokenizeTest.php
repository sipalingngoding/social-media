<?php

namespace SipalingNgoding\MVC\libs;

use PHPUnit\Framework\TestCase;
use SipalingNgoding\MVC\app\Database;
use SipalingNgoding\MVC\repository\UserRepository;

class TokenizeTest extends TestCase
{
    private UserRepository $userRepository;
    protected function setUp(): void
    {
        Database::getConnection();
        $userRepository = new UserRepository(Database::$conn);
        $this->userRepository = $userRepository;
        $userRepository->deleteAll();
        $userRepository->insertUserTest();
    }

    public function testCreateToken():void
    {
        $lastId = $this->userRepository->lastUserId();
        $token = Tokenize::createToken($lastId);
        self::assertNotSame('',$token);
        var_dump($token);
    }

    public function testVerifyTokenSuccess():void
    {
        try {
            $lastId = $this->userRepository->lastUserId();
            $token = Tokenize::createToken($lastId);
            $decoded = Tokenize::verifyToken($token);
            self::assertSame($lastId,$decoded->id);
        }catch (\Exception $exception)
        {
            echo $exception->getMessage();
        }
    }

    public function testVerifyTokenFailInvalid():void
    {
        $lastId = $this->userRepository->lastUserId();
        $token = Tokenize::createToken($lastId);
        self::expectException(\Exception::class);
        Tokenize::verifyToken($token."dsa");
    }
}

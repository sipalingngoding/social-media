<?php

namespace SipalingNgoding\MVC\repository;

use PHPUnit\Framework\TestCase;
use SipalingNgoding\MVC\app\Database;
use SipalingNgoding\MVC\model\User;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

class userRepositoryTest extends TestCase
{
    private UserRepository $userRepository;
    protected function setUp(): void
    {
        Database::getConnection();
        $this->userRepository  = new UserRepository(Database::$conn);
        $this->userRepository->deleteAll();
        $this->userRepository->insertUserTest();
    }

    public function testFindAll():void
    {
        $users = $this->userRepository->findAll();
        self::assertCount(2,$users);
    }

    public function testFindById():void
    {
        $lastID = $this->userRepository->lastUserId();
        $user = $this->userRepository->findById($lastID);
        self::assertSame('budiman@gmail.com',$user['email']);
        self::assertSame('Budiman123?',$user['password']);
        self::assertSame('Budiman Aja',$user['full_name']);
        self::assertSame('Jakarta',$user['address']);
    }

    public function testFindByIdNotFound():void
    {
        $id = $this->userRepository->lastUserId() +1;
        $user = $this->userRepository->findById($id);
        self::assertNull($user);
    }

    public function testFindByEmail():void
    {
        $user = $this->userRepository->findByEmail('budiman@gmail.com');
        self::assertSame('budiman@gmail.com',$user['email']);
        self::assertSame('Budiman123?',$user['password']);
        self::assertSame('Budiman Aja',$user['full_name']);
        self::assertSame('Jakarta',$user['address']);
    }

    public function testFindByEmailNotFound():void
    {
        $user = $this->userRepository->findByEmail('admin@gmail.com');
        self::assertNull($user);
    }



    public function testInsert():void
    {
        $userNew = new User('siska@gmail.com','Siska123?','Siska Aja','Papua');
        $id = $this->userRepository->insert($userNew);
        self::assertSame($this->userRepository->lastUserId(),$id);
        $users = $this->userRepository->findAll();
        self::assertCount(3,$users);
    }

    public function testUpdate():void
    {
        $userUpdate = new User('diory@gmail.com','Diory123?','Diory Pribadi Sinaga','Bekasi');
        $id = $this->userRepository->lastUserId() - 1;
        self::assertTrue($this->userRepository->update($userUpdate,$id));
        $user = $this->userRepository->findById($id);
        assertSame('Bekasi',$user['address']);
        assertSame('diory@gmail.com',$user['email']);
        assertSame('Diory123?',$user['password']);
        assertSame('Diory Pribadi Sinaga',$user['full_name']);
    }

    public function testDelete():void
    {
        $lastId = $this->userRepository->lastUserId();
        assertTrue($this->userRepository->delete($lastId));
        $users = $this->userRepository->findAll();
        self::assertCount(1,$users);
    }
}

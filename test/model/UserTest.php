<?php

namespace SipalingNgoding\MVC\model;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public static function additionalProvider():array
    {
        return [
            ['diory@gmail.com','Diory123?','Diory Pribadi Sinaga','Bandung'],
            ['budiman@gmail.com','Budiman123?','Budiman','Jakarta'],
            ['siska@gmail.com','Siska123?','Siska Aja','Pekanbaru'],
        ];
    }

    #[DataProvider('additionalProvider')]
    public function testModelUser($email,$password,$full_name,$address):void
    {
        $user = new User($email,$password,$full_name,$address);
        self::assertInstanceOf(User::class,$user);
        self::assertObjectHasProperty('email',$user);
        self::assertObjectHasProperty('password',$user);
        self::assertObjectHasProperty('full_name',$user);
        self::assertObjectHasProperty('address',$user);
        self::assertSame($user->email,$email);
        self::assertSame($user->password,$password);
        self::assertSame($user->full_name,$full_name);
        self::assertSame($user->address,$address);
    }
}

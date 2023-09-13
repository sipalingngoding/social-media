<?php

namespace SipalingNgoding\MVC\libs;

use Dotenv\Dotenv;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Tokenize
{
    public static function secretKey()
    {
        $dotenv = Dotenv::createImmutable(__DIR__."/../../");
        $dotenv->safeLoad();
        return $_ENV['SECRET_KEY'];
    }

    public static function createToken(int $id):string
    {
        $payload = [
            'id'=>$id,
            'exp'=>time()+3600,
        ];

        return  JWT::encode($payload,self::secretKey(),'HS256');
    }

    public static function verifyToken(string $jwt) : \stdClass
    {
        return JWT::decode($jwt,new Key(self::secretKey(),'HS256'));
    }

}

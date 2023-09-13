<?php

namespace SipalingNgoding\MVC\app;

use Dotenv\Dotenv;

class Database
{
    public static \PDO $conn;

    static function getConnection(string $mode = 'test'):\PDO
    {
        $dotenv = Dotenv::createImmutable(__DIR__."/../../");
        $dotenv->safeLoad();
        extract($_ENV);
        self::$conn =  new \PDO("mysql:host=$HOST;dbname=".($mode!=='test'?$DATABASE : $DATABASE_TEST),$USER,$PASSWORD);
        return self::$conn;
    }

    static function commit():void
    {
        self::$conn->commit();
    }

    static function rollBack():void
    {
        self::$conn->rollBack();
    }


}

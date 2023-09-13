<?php

namespace SipalingNgoding\MVC\app;

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    public function testConnection():void
    {
        Database::getConnection();
        $conn = Database::$conn;
        self::assertNotNull($conn);
    }

    public function testConnectionSame():void
    {
        Database::getConnection();
        $conn1 = Database::$conn;
        Database::getConnection();
        $conn2 = Database::$conn;
        self::assertSame($conn2,$conn2);
    }

    public function testConnectionNotSame():void
    {
        Database::getConnection();
        $conn1 = Database::$conn;
        Database::getConnection('development');
        $conn2 = Database::$conn;
        $this->assertNotSame($conn1,$conn2);
    }
}

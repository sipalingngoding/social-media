<?php

namespace SipalingNgoding\MVC\libs;

use PHPUnit\Framework\TestCase;

class FlashTest extends TestCase
{
    public function testCreateFlashMessage():void
    {
        Flash::create_flash_message('login','Login Berhasil','success');
        $flash_messages = $_SESSION['FLASH_MESSAGES'];
        self::assertIsArray($flash_messages);
        self::assertCount(1,$flash_messages);
        self::assertArrayHasKey('login',$flash_messages);
        self::assertArrayHasKey('message',$flash_messages['login']);
        self::assertArrayHasKey('type',$flash_messages['login']);
        self::assertSame('Login Berhasil',$flash_messages['login']['message']);
        self::assertSame('success',$flash_messages['login']['type']);
    }

    public function testDisplayFlashMessage():void
    {
        Flash::create_flash_message('login','Login Berhasil','success');
        Flash::display_flash_message('login');
        self::expectOutputRegex('/Login Berhasil/i');
        self::expectOutputRegex('/success/i');
    }

    public function testDisplayAllFlashMessage():void
    {
        Flash::create_flash_message('login','Login Berhasil','success');
        Flash::create_flash_message('info','Silahkan Login','info');
        Flash::display_all_flash_message();
        self::expectOutputRegex('/Login Berhasil/i');
        self::expectOutputRegex('/Silahkan Login/i');
        self::expectOutputRegex('/success/i');
        self::expectOutputRegex('/info/i');
    }

    public function testFlashSampleOne():void
    {
        Flash::flash('register','Register Berhasil','success');
        Flash::flash('login','Silahkan Login','info');
        Flash::flash('register');
        self::expectOutputRegex('/Register Berhasil/i');
        self::expectOutputRegex('/success/i');
//        self::expectOutputRegex('/Silahkan Login/i');
    }

    public function testFlashSampleTwo():void
    {
        Flash::flash('register','Register Berhasil','success');
        Flash::flash('login','Silahkan Login','info');
        Flash::flash();
        self::expectOutputRegex('/Register Berhasil/i');
        self::expectOutputRegex('/success/i');
        self::expectOutputRegex('/Silahkan Login/i');
        self::expectOutputRegex('/info/i');
    }
}

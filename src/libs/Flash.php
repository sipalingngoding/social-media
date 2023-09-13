<?php

namespace SipalingNgoding\MVC\libs;

class Flash
{
    const FLASH = "FLASH_MESSAGES";
    const FLASH_ERROR = "danger";
    const FLASH_SUCCESS = 'success';
    const FLASH_WARNING = 'warning';
    const FLASH_INFO = "info";

    static function create_flash_message(string $name, string $message, string $type):void
    {
        if (isset($_SESSION[self::FLASH][$name])) unset($_SESSION[self::FLASH][$name]);
        $_SESSION[self::FLASH][$name] = ["message"=>$message,'type'=>$type];
    }

    static function display_flash_message(string $name):void
    {
        if(!isset($_SESSION[self::FLASH][$name])) return;
        $flash_message = $_SESSION[self::FLASH][$name];
        unset($_SESSION[self::FLASH][$name]);
        extract($flash_message);
        echo "<div class='alert alert-$type' role='alert'>
            $message
        </div>";
    }

    static function display_all_flash_message():void
    {
        if(!isset($_SESSION[self::FLASH])) return;
        $flash_messages = $_SESSION[self::FLASH];
        unset($_SESSION[self::FLASH]);
        foreach ($flash_messages as $flash_message)
        {
            extract($flash_message);
            echo "<div class='alert alert-$type' role='alert'>
            $message
            </div>";
        }
    }

    static function flash(string $name = "",string $message = "", string $type = ""):void
    {
        if($name !== '' && $message!== '' && $type!==''){
            self::create_flash_message($name,$message,$type);
        }elseif ($name !== '' && $message === '' && $type === ''){
            self::display_flash_message($name);
        }elseif ($name === '' && $message === '' && $type === ""){
            self::display_all_flash_message();
        }
    }
}

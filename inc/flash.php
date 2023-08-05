<?php

const FLASH = "FLASH_MESSAGES";
const FLASH_ERROR = "danger";
const FLASH_SUCCESS = 'success';
const FLASH_WARNING = 'warning';
const FLASH_INFO = "info";

function create_flash_message(string $name, string $message, string $type):void
{
    if (isset($_SESSION[FLASH][$name])) unset($_SESSION[FLASH][$name]);
    $_SESSION[FLASH][$name] = ["message"=>$message,'type'=>$type];
}

function display_flash_message(string $name):void
{
    if(!isset($_SESSION[FLASH][$name])) return;
    $flash_message = $_SESSION[FLASH][$name];
    unset($_SESSION[FLASH][$name]);
    extract($flash_message);
    echo "<div class='alert alert-$type' role='alert'>
            $message
        </div>";
}

function display_all_flash_message():void
{
    if(!isset($_SESSION[FLASH])) return;
    $flash_messages = $_SESSION[FLASH];
    unset($_SESSION[FLASH]);
    foreach ($flash_messages as $flash_message)
    {
        extract($flash_message);
        echo "<div class='alert alert-$type' role='alert'>
            $message
        </div>";
    }
}

function flash(string $name = "",string $message = "", string $type = ""):void
{
    if($name !== '' && $message!== '' && $type!==''){
        create_flash_message($name,$message,$type);
    }elseif ($name !== '' && $message === '' && $type === ''){
        display_flash_message($name);
    }elseif ($name === '' && $message === '' && $type === ""){
        display_all_flash_message();
    }
}

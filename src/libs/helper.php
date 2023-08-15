<?php


use JetBrains\PhpStorm\NoReturn;

function view(string $filename, array $data = []):void
{
    extract($data);
    require_once __DIR__."/../view/".$filename.".php";
}

function is_post_request():bool
{
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
}

function is_get_request():bool
{
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'GET';
}

#[NoReturn] function redirect(string $url):void
{
    header("Location:$url");
    exit();
}

#[NoReturn] function redirect_with(string $url, array $data):void
{
    foreach ($data as $key=>$value){
        $_SESSION[$key] = $value;
    }
    redirect($url);
}

function session_flash(...$keys):array
{
    $data = [];
    foreach ($keys as $key){
        if(isset($_SESSION[$key])){
            $data[$key] = $_SESSION[$key];
            unset($_SESSION[$key]);
        }else{
            $data[$key] = [];
        }
    }
    return $data;
}

#[NoReturn] function redirect_with_message(string $url, string $message, string $type = FLASH_ERROR):void
{
    flash('flash_'.uniqid(),$message,$type);
    redirect($url);
}

function timestamp(string $time):int
{
    [$tanggal,$jam] = explode("T",$time);
    $tanggal = explode('-',$tanggal);
    $jam = explode(':',$jam);
    return mktime($jam[0],$jam[1],00,$tanggal[1],$tanggal[2],$tanggal[0]);
}

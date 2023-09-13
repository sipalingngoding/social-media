<?php

namespace SipalingNgoding\MVC\middleware;

use JetBrains\PhpStorm\NoReturn;
use SipalingNgoding\MVC\app\Database;
use SipalingNgoding\MVC\libs\Flash;
use SipalingNgoding\MVC\libs\Helper;
use SipalingNgoding\MVC\repository\userRepository;
use SipalingNgoding\MVC\service\userService;

class AuthenticationMiddleware
{
    private userService $userService;
    public function __construct()
    {
        $this->userService = new userService(new userRepository(Database::$conn));
    }

    #[NoReturn] public function notLogin():void
    {
        $user = $this->userService->current();
        if($user !== null) Helper::redirect_with_message('/','Anda sudah login!. Logout terlebih dahulu','warning');
    }

    #[NoReturn] public function mustLogin():void
    {
        $user = $this->userService->current();
        if($user === null){
            Flash::flash('login','Silahkan Login','danger');
            Helper::redirect('/login');
        }
    }
}

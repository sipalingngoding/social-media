<?php

namespace SipalingNgoding\MVC\middleware;

use JetBrains\PhpStorm\NoReturn;
use SipalingNgoding\MVC\app\Database;
use SipalingNgoding\MVC\libs\Flash;
use SipalingNgoding\MVC\libs\Helper;
use SipalingNgoding\MVC\repository\UserRepository;
use SipalingNgoding\MVC\service\UserService;

class AuthenticationMiddleware
{
    private UserService $userService;
    public function __construct()
    {
        $this->userService = new UserService(new UserRepository(Database::$conn));
    }

    #[NoReturn] public function notLogin():void
    {
        $user = $this->userService->current();
        if($user !== null) Helper::redirect('/');
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

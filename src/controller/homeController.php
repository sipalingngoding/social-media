<?php

namespace SipalingNgoding\MVC\controller;

use SipalingNgoding\MVC\app\Database;
use SipalingNgoding\MVC\libs\Helper;
use SipalingNgoding\MVC\repository\userRepository;
use SipalingNgoding\MVC\service\userService;

class homeController
{
    private userService $userService;
    public function __construct()
    {
        $this->userService = new userService(new userRepository(Database::$conn));
    }

    public function index():void
    {
        $user = $this->userService->current();
        Helper::view('/user/home',['title'=>'Home','user'=>$user]);
    }
}

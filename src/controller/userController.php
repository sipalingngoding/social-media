<?php

namespace SipalingNgoding\MVC\controller;

use JetBrains\PhpStorm\NoReturn;
use SipalingNgoding\MVC\app\Database;
use SipalingNgoding\MVC\libs\Flash;
use SipalingNgoding\MVC\libs\Helper;
use SipalingNgoding\MVC\repository\userRepository;
use SipalingNgoding\MVC\service\userService;

class userController
{
    private userService $userService;
    public function __construct()
    {
        $this->userService = new userService(new userRepository(Database::$conn));
    }

    public function login():void
    {
        Helper::view('login',['title'=>'Login']);
    }

    public function postLogin():void
    {
        try {
            $token = $this->userService->login();
            setcookie('cookie',$token,time()+3600);
            Helper::redirect('/');
        }catch (\Exception $exception) {
            Flash::flash('error_login',$exception->getMessage(),'danger');
            Helper::redirect('/login');
        }
    }

    public function register():void
    {
        Helper::view('register',['title'=>'Register','css'=>'register']);
    }

    public function postRegister():void
    {
        try {
            $this->userService->register();
            Helper::redirect_with_message('/login','Berhasil register','success');
        }catch (\Exception $exception)
        {
            Helper::redirect('/register');
        }
    }

    #[NoReturn] public function logout():void
    {
        setcookie('cookie','',1);
        Helper::redirect_with_message('/login','Berhasil Logout','success');
    }
}

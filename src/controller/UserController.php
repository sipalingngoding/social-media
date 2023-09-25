<?php

namespace SipalingNgoding\MVC\controller;

use JetBrains\PhpStorm\NoReturn;
use SipalingNgoding\MVC\app\Database;
use SipalingNgoding\MVC\libs\Flash;
use SipalingNgoding\MVC\libs\Helper;
use SipalingNgoding\MVC\repository\UserRepository;
use SipalingNgoding\MVC\service\UserService;

class UserController
{
    private UserService $userService;
    public function __construct()
    {
        $this->userService = new UserService(new UserRepository(Database::$conn));
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
            if(!isset($_SESSION['errors_register'])){
                Helper::redirect_with_message('/register',$exception->getMessage());
            }
            Helper::redirect('/register');
        }
    }

    #[NoReturn] public function logout():void
    {
        setcookie('cookie','',1);
        Helper::redirect_with_message('/login','Berhasil Logout','success');
    }

    public function updateProfile():void
    {
        try {
            $user = $this->userService->current();
            $photo = null;
            $errors = [];
            //Upload File
            $image = Helper::upload('photo',3,['image/jpg','image/png','image/jpeg'],$errors,true);
            if(sizeof($errors)>0) throw new \Exception(array_values($errors)[0]);
            if($image !== false) $photo = $image;

            $this->userService->update($user['id'],$photo);
            Helper::redirect_with_message('/profile','Update Berhasil','success');
        }catch (\Exception $exception)
        {
            Helper::redirect_with_message('/profile',$exception->getMessage());
        }
    }

    public function updatePassword():void
    {
        try {
            $user = $this->userService->current();
            $this->userService->updatePassword($user['id']);
            Helper::redirect_with_message('/profile','Update password berhasil','success');
        }catch (\Exception $exception)
        {
            Helper::redirect_with_message('/profile',$exception->getMessage());
        }
    }
}

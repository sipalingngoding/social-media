<?php

namespace SipalingNgoding\MVC\controller;

use SipalingNgoding\MVC\app\Database;
use SipalingNgoding\MVC\libs\Helper;
use SipalingNgoding\MVC\repository\PhotoRepository;
use SipalingNgoding\MVC\repository\UserRepository;
use SipalingNgoding\MVC\service\PhotoService;
use SipalingNgoding\MVC\service\UserService;

class HomeController
{
    private UserService $userService;
    private PhotoService $photoService;
    public function __construct()
    {
        $this->userService = new UserService(new UserRepository(Database::$conn));
        $this->photoService = new PhotoService(new PhotoRepository(Database::$conn));
    }

    public function index():void
    {
        $user = $this->userService->current();
        $photos = $this->photoService->getAllPhotoUser($user['id']);
        Helper::view('/user/home',['title'=>'Home','user'=>$user,'photos'=>$photos,'js'=>'home']);
    }


    public function profile():void
    {
        $user = $this->userService->current();
        Helper::view('/user/profile',['title'=>'Profile','user'=>$user]);
    }

    public function beranda():void
    {
        $user = $this->userService->current();
        $photos = $this->photoService->findAllNotPhotoUser($user['id']);
        Helper::view('beranda',['title'=>'Beranda','user'=>$user,'photos'=>$photos]);
    }

    public function user():void
    {
        [$inputs, ] = Helper::filter(['id'],['id'=>'int;required'],INPUT_GET);
        $userPhoto = $this->userService->getById($inputs['id']);
        $photos = $this->photoService->getAllPhotoUser($userPhoto['id']);
        $user = $this->userService->current();
        if($user['id'] === $userPhoto['id']) Helper::redirect('/');

        Helper::view('/user',['title'=>"Photos ".$userPhoto['full_name'],'photos'=>$photos,'user'=>$user,'userPhoto'=>$userPhoto]);
    }
}

<?php

namespace SipalingNgoding\MVC;

session_start();
date_default_timezone_set('Asia/Jakarta');

use SipalingNgoding\MVC\app\Database;
use SipalingNgoding\MVC\app\Router;
use SipalingNgoding\MVC\controller\CommentController;
use SipalingNgoding\MVC\controller\HomeController;
use SipalingNgoding\MVC\controller\PhotoController;
use SipalingNgoding\MVC\controller\UserController;
use SipalingNgoding\MVC\middleware\AuthenticationMiddleware;
use SipalingNgoding\MVC\model\User;

require __DIR__."/../vendor/autoload.php";

Database::getConnection('run');

Router::get('/',[HomeController::class,'index'],[[AuthenticationMiddleware::class,'mustLogin']]);

Router::get('/login',[UserController::class,'login'],[[AuthenticationMiddleware::class,'notLogin']]);
Router::post('/login',[UserController::class,'postLogin'],[[AuthenticationMiddleware::class,'notLogin']]);

Router::get('/register',[UserController::class,'register'],[[AuthenticationMiddleware::class,'notLogin']]);
Router::post('/register',[UserController::class,'postRegister'],[[AuthenticationMiddleware::class,'notLogin']]);

Router::get('/logout',[UserController::class,'logout'],[[AuthenticationMiddleware::class,'mustLogin']]);

Router::get('/profile',[HomeController::class,'profile'],[[AuthenticationMiddleware::class,'mustLogin']]);

Router::post('/updateProfile',[UserController::class,'updateProfile'],[[AuthenticationMiddleware::class,'mustLogin']]);

Router::post('/updatePassword',[UserController::class,'updatePassword'],[[AuthenticationMiddleware::class,'mustLogin']]);

// Photo

Router::get('/addPhoto',[PhotoController::class,'add'],[[AuthenticationMiddleware::class,'mustLogin']]);
Router::post('/addPhoto',[PhotoController::class,'postAdd'],[[AuthenticationMiddleware::class,'mustLogin']]);

Router::get('/update',[PhotoController::class,'update'],[[AuthenticationMiddleware::class,'mustLogin']]);
Router::post('/update',[PhotoController::class,'postUpdate'],[[AuthenticationMiddleware::class,'mustLogin']]);

Router::get('/photo',[PhotoController::class,'info'],[[AuthenticationMiddleware::class,'mustLogin']]);

Router::get('/photoUser',[PhotoController::class,'findAllPhotoUser'],[[AuthenticationMiddleware::class,'mustLogin']]);

Router::get('/deletePhoto',[PhotoController::class,'delete',[[AuthenticationMiddleware::class,'mustLogin']]]);

//Comment

Router::post('/comment',[CommentController::class,'addComment'],[[AuthenticationMiddleware::class,'mustLogin']]);

Router::post('/updateComment',[CommentController::class,'updateComment'],[[AuthenticationMiddleware::class,'mustLogin']]);

Router::get('/deleteComment',[CommentController::class,'delete'],[[AuthenticationMiddleware::class,'mustLogin']]);


//
Router::get('/beranda',[HomeController::class,'beranda'],[[AuthenticationMiddleware::class,'mustLogin']]);

Router::get('/user',[HomeController::class,'user'],[[AuthenticationMiddleware::class,'mustLogin']]);
Router::run();

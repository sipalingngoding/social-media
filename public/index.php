<?php

namespace SipalingNgoding\MVC;

session_start();
date_default_timezone_set('Asia/Jakarta');

use SipalingNgoding\MVC\app\Database;
use SipalingNgoding\MVC\app\Router;
use SipalingNgoding\MVC\controller\homeController;
use SipalingNgoding\MVC\controller\userController;
use SipalingNgoding\MVC\middleware\AuthenticationMiddleware;

require __DIR__."/../vendor/autoload.php";

Database::getConnection('run');

Router::get('/',[homeController::class,'index'],[[AuthenticationMiddleware::class,'mustLogin']]);

Router::get('/login',[userController::class,'login'],[[AuthenticationMiddleware::class,'notLogin']]);
Router::post('/login',[userController::class,'postLogin'],[[AuthenticationMiddleware::class,'notLogin']]);

Router::get('/register',[userController::class,'register'],[[AuthenticationMiddleware::class,'notLogin']]);
Router::post('/register',[userController::class,'postRegister'],[[AuthenticationMiddleware::class,'notLogin']]);

Router::get('/logout',[userController::class,'logout'],[[AuthenticationMiddleware::class,'mustLogin']]);

Router::run();

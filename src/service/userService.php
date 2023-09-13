<?php

namespace SipalingNgoding\MVC\service;

use SipalingNgoding\MVC\Exception\ClientError;
use SipalingNgoding\MVC\Exception\NotFoundError;
use SipalingNgoding\MVC\libs\Helper;
use SipalingNgoding\MVC\libs\Tokenize;
use SipalingNgoding\MVC\model\User;
use SipalingNgoding\MVC\repository\userRepository;
use SipalingNgoding\MVC\validator;

class userService
{
    private userRepository $userRepository;
    public function __construct(userRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll():array
    {
        return $this->userRepository->findAll();
    }

    /**
     * @throws NotFoundError
     */
    public function getById($id):?array
    {
        $user = $this->userRepository->findById($id);
        if(!$user) throw new NotFoundError('user not found');
        return $user;
    }

    /**
     * @throws \Exception
     */
    public function register():int
    {
        [$inputs,$errors] = validator\User::validateRegisterInput();

        if(sizeof($errors)>0){
            Helper::create_session(['errors_register'=>$errors,'inputs_register'=>$inputs]);
            throw new ClientError(array_values($errors)[0]);
        }

        extract($inputs);
        $checkUserExist = $this->userRepository->findByEmail($email);
        if($checkUserExist) throw new ClientError('email already exist');

        $userNew = new User($email,password_hash($password,PASSWORD_DEFAULT),$full_name,$address);
        return $this->userRepository->insert($userNew);
    }

    /**
     * @throws ClientError
     */
    function login() : string
    {
        [$inputs,$errors]= validator\User::validateLoginInput();
        if(sizeof($errors)>0) throw new ClientError(array_values($errors)[0]);

        extract($inputs);
        $user = $this->userRepository->findByEmail($email);
        if(!$user) throw new ClientError('email or password is wrong');

        $checkPassword = password_verify($password,$user['password']);

        if(!$checkPassword) throw new ClientError('email or password is wrong');

        return Tokenize::createToken($user['id']);
    }

    public function current() : array | null
    {
        $cookie = $_COOKIE['cookie'] ?? null;
        if(!$cookie) return null;
        try {
            $decode = Tokenize::verifyToken($cookie);
            return $this->userRepository->findById($decode->id);
        }catch (\Exception){
            setcookie('cookie','',1);
            return null;
        }
    }

}

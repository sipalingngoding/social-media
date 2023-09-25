<?php

namespace SipalingNgoding\MVC\controller;

use SipalingNgoding\MVC\app\Database;
use SipalingNgoding\MVC\libs\Flash;
use SipalingNgoding\MVC\libs\Helper;
use SipalingNgoding\MVC\repository\CommentRepository;
use SipalingNgoding\MVC\repository\PhotoRepository;
use SipalingNgoding\MVC\repository\UserRepository;
use SipalingNgoding\MVC\service\CommentService;
use SipalingNgoding\MVC\service\PhotoService;
use SipalingNgoding\MVC\service\UserService;

class PhotoController
{
    private PhotoService $photoService;
    private UserService $userService;
    private CommentService $commentService;
    public function __construct()
    {
        $photoRepository = new PhotoRepository(Database::$conn);
        $this->photoService = new PhotoService($photoRepository);
        $this->userService = new UserService(new UserRepository(Database::$conn));
        $this->commentService = new CommentService(new CommentRepository(Database::$conn));
    }

    public function add():void
    {
        Helper::view('photo/add',['title'=>'Add Photo']);
    }

    public function findAllPhotoUser():void
    {
        [$inputs,$errors ] = Helper::filter(['value'],['value'=>'string;required'],INPUT_GET);
        $user = $this->userService->current();

        $desc = $inputs['value'] !== 'asc';
        $photos = $this->photoService->getAllPhotoUser($user['id'],$desc);

        require_once __DIR__."/../ajax/photo.php";
    }

    public function postAdd():void
    {
        try {
            $user = $this->userService->current();
            $errors = [];
            //Upload File
            $image = Helper::upload('photo',3,['image/jpg','image/png','image/jpeg'],$errors);
            if(sizeof($errors)>0) throw new \Exception(array_values($errors)[0]);
            if($image === false) throw new \Exception('Harap inputkan foto');

            $this->photoService->add($image,$user['id']);
            Helper::redirect_with_message('/addPhoto','Add Photo Success','success');
        }catch (\Exception $exception)
        {
            Helper::redirect_with_message('/addPhoto',$exception->getMessage());
        }
    }

    public function update():void
    {
        try {
            [$inputs,$errors] = Helper::filter(['id'],['id'=>'int;required'],INPUT_GET);
            if (sizeof($errors) > 0) Helper::redirect('/');
            $photo = $this->photoService->getOne($inputs['id']);
            $user = $this->userService->current();
            if($photo['userId']  !== $user['id']) Helper::redirect('/');

            Helper::view('photo/update',['title'=>'Update Photo','photo'=>$photo]);
        }catch (\Exception $exception){
            Helper::redirect_with_message('/',$exception->getMessage());
        }
    }

    public function postUpdate():void
    {
        try {

            $errors = [];
            //Upload File
            $image = Helper::upload('photo',3,['image/jpg','image/png','image/jpeg'],$errors);
            if(sizeof($errors)>0) throw new \Exception(array_values($errors)[0]);

            if ($image !== false) $_POST['image'] = $image;

            $user = $this->userService->current();

            $this->photoService->update($user['id']);

            Flash::flash('updateSuccess','update photo success','success');

            header("Refresh:0");
        }catch (\Exception $exception)
        {
            Flash::flash('updateFail',$exception->getMessage(),'danger');
            header("Refresh:0");
        }
    }

    public function info():void
    {

        try {
            [$inputs,$errors] = Helper::filter(['id'],['id'=>'int;required'],INPUT_GET);
            if (sizeof($errors) > 0) Helper::redirect('/');
            $photo = $this->photoService->getOne($inputs['id']);
            $photo['user'] = $this->userService->getById($photo['userId']);
            $user = $this->userService->current();
            $comments = $this->commentService->getAll($photo['id']);

            Helper::view('photo/info',['title'=>'Photo','photo'=>$photo,'user'=>$user,'comments'=>$comments]);
        }catch (\Exception $exception)
        {
            Helper::redirect_with_message('/',$exception->getMessage());
        }
    }

    public function delete():void
    {
        try {
            $user = $this->userService->current();
            $this->photoService->delete($user['id']);
            Helper::redirect_with_message('/','Berhasil dihapus','success');
        }catch (\Exception $exception)
        {
            Helper::redirect_with_message('/',$exception->getMessage());
        }
    }
}

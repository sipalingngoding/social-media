<?php

namespace SipalingNgoding\MVC\controller;

use SipalingNgoding\MVC\app\Database;
use SipalingNgoding\MVC\Exception\ClientError;
use SipalingNgoding\MVC\libs\Flash;
use SipalingNgoding\MVC\libs\Helper;
use SipalingNgoding\MVC\repository\CommentRepository;
use SipalingNgoding\MVC\repository\UserRepository;
use SipalingNgoding\MVC\service\CommentService;
use SipalingNgoding\MVC\service\UserService;

class CommentController
{
    private UserService $userService;
    private CommentService $commentService;
    public function __construct()
    {
        $this->userService = new UserService(new UserRepository(Database::$conn));
        $this->commentService = new CommentService(new CommentRepository(Database::$conn));
    }

    public function addComment():void
    {
        [$inputs,$errors] = Helper::filter(['id'],['id'=>'int;required'],INPUT_GET);
        try {
            $user = $this->userService->current();

            if(sizeof($errors) > 0) throw new ClientError(array_values($errors)[0]);

            $this->commentService->add($user['id'],$inputs['id']);
            Helper::redirect_with_message("/photo?id=".$inputs['id'],'Comment berhasil ditambahkan','success');
        }catch (\Exception $exception)
        {
            Helper::redirect_with_message("/photo?id=".$inputs['id'],$exception->getMessage());
        }
    }

    public function updateComment():void
    {
        try {
            [$inputs,$errors] = Helper::filter(['id'],['id'=>'int;required'],INPUT_GET);

            if (sizeof($errors)>0) throw new ClientError('invalid id');
            $user = $this->userService->current();
            $this->commentService->update($inputs['id'],$user['id']);
            Flash::flash('updateCommentSuccess','update comment success','success');
        }catch (\Exception $exception)
        {
            Flash::flash('updateCommentFail',$exception->getMessage(),'danger');
        } finally {
            echo "<script>history.back()</script>";
        }
    }


    public function delete():void
    {
        try {
            $user = $this->userService->current();
            $this->commentService->delete($user['id']);
            Flash::flash('deleteCommentSuccess','Delete Comment Success','success');
            echo "<script>history.back()</script>";
        }catch (\Exception $exception){
            Flash::flash('deleteCommentFail',$exception->getMessage(),'danger');
            echo "<script>history.back()</script>";
        }
    }
}

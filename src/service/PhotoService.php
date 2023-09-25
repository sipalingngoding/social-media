<?php

namespace SipalingNgoding\MVC\service;

use SipalingNgoding\MVC\app\Database;
use SipalingNgoding\MVC\Exception\ClientError;
use SipalingNgoding\MVC\Exception\NotFoundError;
use SipalingNgoding\MVC\libs\Helper;
use SipalingNgoding\MVC\model\Photo;
use SipalingNgoding\MVC\repository\PhotoRepository;
use SipalingNgoding\MVC\repository\UserRepository;

class PhotoService
{
    private PhotoRepository $photoRepository;

    public function __construct(PhotoRepository $photoRepository)
    {
        $this->photoRepository = $photoRepository;
    }

    public function getAll(bool $desc = true):array
    {
        return $this->photoRepository->findAll($desc);
    }

    public function getAllPhotoUser(int $userId, bool $desc = true):array
    {
        return $this->photoRepository->findAllPhotoUser($userId,$desc);
    }

    public function findAllNotPhotoUser(int $userId):array{
        return $this->photoRepository->findAllNotPhotoUser($userId);
    }

    /**
     * @throws NotFoundError
     */
    public function getOne(int $id):array
    {
        $photo  = $this->photoRepository->findOne($id);
        if(!$photo) throw new NotFoundError('photo not found');
        return $photo;
    }

    /**
     * @throws ClientError
     */
    public function add(string $image, int $userId):int
    {
        [$inputs,$errors] = \SipalingNgoding\MVC\validator\Photo::validateInsertPhoto();
        if(sizeof($errors) > 0) {
            unlink(__DIR__.'/../../public/uploads/'.$image);
            throw new ClientError(array_values($errors)[0]);
        };
        $createdAt = date('Y-m-d H:i:s');
        extract($inputs);
        $photo = new Photo($title,$description,$image,$userId,$createdAt,$createdAt);
        return $this->photoRepository->insert($photo);
    }

    /**
     * @throws ClientError
     */
    public function update(int $userId):bool
    {
        [$inputs,$errors] = Helper::filter(['id'],['id'=>'int;required | int'],INPUT_GET);
        if(sizeof($errors)>0) throw new ClientError(array_values($errors)[0]);
        $photo = $this->getOne($inputs['id']);

        if($photo['userId'] !== $userId) throw new ClientError('cannot update this photo');

        [$inputs,$errors] = \SipalingNgoding\MVC\validator\Photo::validateInsertPhoto();
        if(sizeof($errors)>0) throw new ClientError(array_values($errors)[0]);
        extract($inputs);

        $image = $photo['image'];
        if(isset($_POST['image'])){
            unlink(__DIR__.'/../../public/uploads/'.$photo['image']);
            $image = $_POST['image'];
        }
        $photoUpdate = new Photo($title,$description,$image,$userId,'',date('Y-m-d H:i:s'),$photo['id']);
        return $this->photoRepository->update($photoUpdate);
    }

    /**
     * @throws NotFoundError
     * @throws ClientError
     */
    public function delete(int $userId):bool
    {
        [$inputs,$errors] = Helper::filter(['id'],['id'=>'int;required|int'],INPUT_GET);
        if (sizeof($errors) > 0) throw new ClientError(array_values($errors)[0]);
        $photo = $this->getOne($inputs['id']);
        if($photo['userId'] !== $userId) throw new ClientError('Anda tidak bisa menghapus foto ini');

        unlink(__DIR__.'/../../public/uploads/'.$photo['image']);
        return $this->photoRepository->delete($inputs['id']);
    }
}

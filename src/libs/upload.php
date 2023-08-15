<?php


function upload(string $name, float $size, array $type, &$errors):bool | string
{
    $check = isset($_FILES[$name]) && $_FILES[$name]['size'] > 0;
    if(!$check) return false;

    $dir = __DIR__."/../../public/uploads";
    $file = $_FILES[$name];

    if($file['error'] === UPLOAD_ERR_OK){
        if(!in_array($file['type'],$type)){
            $errors['upload'] = 'Tipe file tidak sesuai';
            return false;
        }

        if($file['size'] > $size * 1024 * 1024){
            $errors['upload'] = "File terlalu besar! maksimal $size mb";
            return false;
        }

        $name = time(). "_".basename($file['name']);
        move_uploaded_file($file['tmp_name'],"$dir/$name");
        flash('upload',"File berhasil diupload",FLASH_SUCCESS);
        return $name;
    }
    flash('upload','Terjadi Error',FLASH_ERROR);
    return false;
}

<?php

if(!isset($_FILES['files'])){
    flash('upload','Invalid file upload operation',FLASH_ERROR);
    header("Location:index.php");
    exit();
}

$uploadDir = __DIR__."/../uploads";
$allowedType = ["image/jpeg",'image/png','image/jpg'];

$files = $_FILES['files'];

for ($key = 0;$key < sizeof($files['error']);$key++)
{
    $no = $key+1;
    if($files['error'][$key] !== UPLOAD_ERR_OK){
        flash("upload$no","File $no tidak dapat di upload",FLASH_ERROR);
        continue;
    }
    if(!in_array($files['type'][$key],$allowedType)){
        flash("upload$no","File $no tipe data tidak sesuai",FLASH_ERROR);
        continue;
    }

    if($files['size'][$key] > (1.5 * 1024 * 1024)){
        flash("upload$no","File $no Terlalu besar",FLASH_ERROR);
        continue;
    }
    $name = time(). "_".basename($files["name"][$key]);
    move_uploaded_file($files['tmp_name'][$key],"$uploadDir/$name");
    flash("upload$no","File $no berhasil di upload",FLASH_SUCCESS);
}

header("Location:index.php");
exit();

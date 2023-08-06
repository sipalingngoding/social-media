<?php

//Exist file
if(!isset($_FILES['file'])){
    flash('upload','Invalid file upload operation',FLASH_ERROR);
    header("Location:index.php");
    exit();
}
$uploadDir = __DIR__."/../uploads";
$allowedType = ["image/jpeg",'image/png'];

$file = $_FILES['file'];
extract($file);

//Error file
if($error !== UPLOAD_ERR_OK){
    flash('upload','Terjadi Error',FLASH_ERROR);
    header("Location:index.php");
    exit();
}

//Type file
if(!in_array($type,$allowedType)){
    flash('upload','Tipe file tidak diijinkan',FLASH_ERROR);
    header("Location:index.php");
    exit();
}

//max file size
if($size>(1.5 * 1024 * 1024)){
    flash('upload','File cukup besar',FLASH_ERROR);
    header("Location:index.php");
    exit();
}

//Upload File
$name = time()."_".basename($name);

move_uploaded_file($tmp_name,"$uploadDir/$name");

flash("upload","Berhasil di upload",FLASH_SUCCESS);

header("Location:index.php");

exit();

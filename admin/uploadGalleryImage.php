<?php
session_start();
include "../config.php";
include "../autologout.php";
include "../sympDetail.php";

if(isset($_POST['save-btn'])){
    if($_POST['save-btn'] == "save"){
        $allowedType = array( "png" => "image/png", "jpg" => "image/jpeg", "jpeg" => "image/jpeg");
        
        $folder  = $_POST['folder'];

        $image   = $_FILES['img'];
        $imgExt  = pathinfo( $image['name'], PATHINFO_EXTENSION);
        $imgType = $image['type'];
        $imgName = (count(glob("../img/gallery/*.*"))+1).".".$imgExt;

        if(!(array_key_exists( $imgExt, $allowedType))){
            header("Location: galleryEdit.php?msg=notSupport");
        } else if(in_array( $imgType, $allowedType)){
            if(move_uploaded_file( $image['tmp_name'], $folder.$imgName)){
                header("Location: galleryEdit.php?msg=uploaded");
            } else {
                header("Location: galleryEdit.php?msg=cannotUpload");
            }
        } else {
            header("Location: galleryEdit.php?msg=notSupport");
        }
    }
    if($_POST['save-btn'] == "delete"){
        $fileName = $_POST['file-name'];

        if(unlink($fileName)){
            header("Location: galleryEdit.php?msg=deleted");
        } else {
            header("Location: galleryEdit.php?msg=cannotDelete");
        }
    }
}
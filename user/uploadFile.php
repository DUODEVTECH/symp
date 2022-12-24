<?php
session_start();
include "../config.php";
include "../sympDetail.php";

function validate($data) {
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function check($id){
    global $conn;
    $check = mysqli_query($conn, "SELECT ID FROM users WHERE ID='$id'");
    if (mysqli_num_rows($check) == 1)
        return $id;
    else{
        header("Location: uploadFileIF.php?msg=nouser");
    }
}

if (isset($_POST['submit']) && $_POST['submit'] == 'upload') {
    $allowType = array("ppt" => "application/vnd.ms-powerpoint", "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation", "doc" => "application/msword", "docx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "pdf" => "application/pdf");

    // getting team id
    $tl       = check(validate($_POST['tl']));
    $tm2      = check(validate($_POST['tm2']));
    $tm3      = check(validate($_POST['tm3']));

    $topic    = validate($_POST['topic']);
    $abstract = validate($_POST['abstract']);

    $file     = $_FILES['ppt'];
    $fileExt  = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileType = $file['type'];
    $newFileName =  $tl . "." . $fileExt;

    if (!(array_key_exists($fileExt, $allowType))) {
        header("Location: uploadFileIF.php?msg=fileNotSupport");
    } else if (in_array($fileType, $allowType)) {

        if (file_exists("../ppt/" . $file['name'])) {
            header("Location: uploadFileIF.php?msg=alreadyUploaded");
        } else {
            if (move_uploaded_file($file['tmp_name'], "../ppt/" . $newFileName)) {
                mysqli_query($conn, "INSERT INTO ppt_files (TL, TEAM_2, TEAM_3, TOPIC, ABSTRACT, FILENAME, PATH) VALUES ('$tl', '$tm2', '$tm3', '$topic', '$abstract', '$newFileName', '../ppt/')");
                header("Location: uploadFileIF.php?msg=uploaded");
            } else {
                header("Location: uploadFileIF.php?msg=cannotUpload");
            }
        }
    } else {
        header("Location: uploadFileIF.php?msg=notSupport");
    }
} else if (isset($_POST['submit']) && $_POST['submit'] == 'delete') {
    $id    = $_POST['id'];

    $files = mysqli_query($conn, "SELECT * FROM ppt_files WHERE TL='$id'");
    $file  = mysqli_fetch_assoc($files);

    unlink($file['PATH'] . $file['FILENAME']);
    mysqli_query($conn, "DELETE FROM ppt_files WHERE TL='$id' AND FILENAME='{$file['FILENAME']}'");
    header("Location:uploadFileIF.php?msg=deleted");
} else {
    header("Location:uploadFileIF.php?msg=upload");
}

<?php
session_start();
include '../config.php';

$id = $_SESSION['ID'];
 
function validate($data) {
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$roll     = validate($_POST['roll']);
$name     = validate($_POST['name']);
$email    = validate($_POST['email']);
$mobile   = validate($_POST['mobile']);
$dep      = validate($_POST['dep']);
$clg      = validate($_POST['eve']);

$sql      = "UPDATE coordinator SET ROLLNO='$roll', NAME='$name', EMAIL='$email', PHONE='$mobile', DEPARTMENT='$dep' WHERE ROLLNO='$id'";

mysqli_query($conn,$sql);
header("Location: coProfile.php?msg=done");
?>
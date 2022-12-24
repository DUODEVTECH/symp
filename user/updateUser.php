<?php
session_start();
include '../config.php';
include "../sympDetail.php";

$id = $_SESSION['ID'];

function validate($data)
{
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$name     = strtoupper(validate($_POST['name']));
$clg_roll = strtoupper(validate($_POST['clg_roll']));
$email    = strtolower(validate($_POST['email']));
$mobile   = validate($_POST['mobile']);
$year     = strtoupper(validate($_POST['year']));
$deg      = strtoupper(validate($_POST['deg']));
$dep      = strtoupper(validate($_POST['dep']));
$clg      = strtoupper(validate($_POST['clg']));

$sql      = "UPDATE users SET NAME='$name', EMAIL='$email', PHONE='$mobile', COLLEGE='$clg', CLG_ROLL='$clg_roll', DEGREE='$deg',DEPARTMENT='$dep',YEAR='$year' WHERE ID='$id'";

mysqli_query($conn, $sql);
header("Location: userProfile.php?msg=done");

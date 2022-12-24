<?php
session_start();
include "../config.php";
include "../sympDetail.php";

$id        = $_POST['sympid'];
$eventName = $_POST['event'];

$check = mysqli_query($conn, "SELECT * FROM user_reg_event WHERE SYMPID='$id' AND EVENT='$eventName'");
if (mysqli_num_rows($check) == 0) {
    mysqli_query($conn, "INSERT INTO user_reg_event (EVENT,DEP,SYMPID) VALUES ( '$eventName','CSE', '$id')");
    header("Location:eventInfo.php?msg=done");
} else
    header("Location:eventInfo.php?msg=exist");

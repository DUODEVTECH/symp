<?php
session_start();
include "../config.php";
include "../autologout.php";

if (isset($_POST['roll'])) {
    $roll = $_POST['roll'];
}

if (isset($_POST['action']) && $_POST['action'] == "ADD") {
    $roll  = $_POST['roll'];
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dep   = $_POST['dep'];
    $event = $_POST['event'];
    $pass  = $_POST['pass'];
    $pos   = $_POST['position'];

    $check = "SELECT * FROM coordinator WHERE ROLLNO='$roll'";
    $insert = "INSERT INTO coordinator ( ROLLNO, NAME, EMAIL, PHONE, PASS, POSITION, DEPARTMENT, EVENT) VALUES ( '$roll', '$name', '$email', '$phone', '$pass', '$pos', '$dep', '$event')";

    if (mysqli_num_rows(mysqli_query($conn, $check)) == 0) {
        mysqli_query($conn, $insert);
        header("Location: coList.php?msg=AD");
    } else
        header("Location: coList.php?msg=exist");
} else if (isset($_POST['action']) && $_POST['action'] == "EDIT") {
    $name = $_POST['name'];
    $dep  = $_POST['dep'];
    $pos  = $_POST['pos'];
    $eve  = $_POST['eve'];
    mysqli_query($conn, "UPDATE coordinator SET NAME='$name', DEPARTMENT='$dep', POSITION='$pos', EVENT='$eve' WHERE ROLLNO='$roll'");

    header("Location: coList.php?msg=ED");
} else if (isset($_POST['action']) && $_POST['action'] == "DELETE") {
    mysqli_query($conn, "DELETE FROM coordinator WHERE ROLLNO='$roll'");
    header("Location: coList.php?msg=DD");
}

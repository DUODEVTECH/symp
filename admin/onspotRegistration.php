<?php 
session_start();
include "../config.php";
include "../autologout.php";
include "../sympDetail.php";

if(isset($_POST['mode'])){
    $mode = $_POST['mode']=='ONLINE' ? 'ONSPOT' : 'ONLINE';
    
    mysqli_query($conn, "ALTER TABLE users ALTER MODE SET DEFAULT '$mode'");
    
    header("Location: userList.php?msg=mode&mode=$mode");
}

if(isset($_GET['sympid'])){
    $id = $_GET['sympid'];

    mysqli_query($conn, "UPDATE users SET PAYMENT='NOTPAID' WHERE ID='$id'");

    header("Location: paymentList.php?msg=notpay");
}

if(isset($_POST['paid-btn'])){
    $id = $_POST['id'];

    mysqli_query($conn, "UPDATE users SET PAYMENT='PAID' WHERE ID='$id'");

    header("Location: paymentList.php?msg=paid");
}
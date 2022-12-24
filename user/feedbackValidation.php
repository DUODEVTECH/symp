<?php
session_start();
include "../config.php";
include "../sympDetail.php";

$sympid = $_SESSION['ID'];
$rate   = 0;
$i      = 1;

while (true){
    if(!isset($_POST["rate-$i"])){
        $i--;
        break;
    }
    $rate += $_POST["rate-$i"];
    $i++;
}

$avg_rate = $rate/$i;
$evt      = $_POST['event'];
$dep      = $_POST['dep'];

mysqli_query( $conn, "INSERT INTO FEEDBACK (SYMPID, EVENT, DEP, RATING) VALUES ('$sympid', '$evt', '$dep', '$avg_rate')");

header("Location: feedback.php?msg=done");
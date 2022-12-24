<?php
session_start();
include "../config.php";
include "../autologout.php";

if (isset($_POST['evnt'])) {
    $evnt = $_POST['evnt'];
}

if (isset($_POST['action']) && $_POST['action'] == 'EDIT') {
    $event  = $_POST["event"];
    $type   = $_POST['type'];
    $dep    = $_POST["dep"];
    $date   = $_POST["date"];
    $ven    = $_POST["venue"];
    $des    = $_POST["des"];
    $date   = str_replace("T", " ", "$date");
    mysqli_query($conn, "UPDATE event SET EVENTS='$event', TYPE='$type',DEPARTMENT='$dep',DATE='$date',VENUE='$ven',DESCRIPTION='$des' WHERE EVENTS='$evnt'");
    header("Location: eventList.php?msg=ED");
} else if (isset($_POST['action']) && $_POST['action'] == 'OPEN') {
    mysqli_query($conn, "UPDATE event SET STATUS='OPEN' WHERE EVENTS='$evnt'");
    header("Location: eventList.php?msg=SOD");
} else if (isset($_POST['action']) && $_POST['action'] == 'CLOSE') {
    mysqli_query($conn, "UPDATE event SET STATUS='CLOSE' WHERE EVENTS='$evnt'");
    header("Location: eventList.php?msg=SCD");
} else if (isset($_POST['action']) && $_POST['action'] == 'DELETE') {
    mysqli_query($conn, "DELETE FROM event WHERE EVENTS='$evnt'");
    header("Location: eventList.php?msg=DD");
} else if (isset($_POST['action']) && $_POST['action'] == 'ADD') {
    $event  = $_POST["event"];
    $dep    = $_POST["dep"];
    $status = $_POST["status"];
    $date   = $_POST["date"];
    $ven    = $_POST["venue"];

    $date   = str_replace("T", " ", "$date");

    $insert = "INSERT INTO event ( EVENTS, TYPE, DEPARTMENT, STATUS, DATE, VENUE) VALUES ('$event','$type','$dep','$status','$date', '$ven')";
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM event WHERE EVENTS='$event'")) == 0) {
        mysqli_query($conn, $insert);
        header("Location: eventList.php?msg=AD");
    } else {
        header("Location: eventList.php?msg=exist");
    }
}

<?php
session_start();
include "../config.php";
include "../sympDetail.php";

if (isset($_POST['evnt'])) {
    $evnt = $_POST['evnt'];
}

// Edit events
if (isset($_POST['action']) && $_POST['action'] == 'EDIT') {
    $event  = $_POST["event"];
    $type   = $_POST['type'];
    $dep    = $_POST["dep"];
    $date   = $_POST["date"];
    $ven    = $_POST["venue"];
    $date   = str_replace("T", " ", "$date");
    $team   = $_POST['team'];
    $maxmem = $_POST['max-mem'];

    // Updating values
    mysqli_query($conn, "UPDATE event SET EVENTS='$event',TYPE='$type',DEPARTMENT='$dep',DATE='$date',VENUE='$ven',TEAM='$team',MAX_MEM='$maxmem' WHERE EVENTS='$evnt'");
    // Redirect to events list page
    header("Location: events.php?msg=ED");
} 

// Change event status to open
else if (isset($_POST['action']) && $_POST['action'] == 'OPEN') {
    mysqli_query($conn, "UPDATE event SET STATUS='OPEN' WHERE EVENTS='$evnt'");
    header("Location: events.php?msg=SOD");
} 

// Change event status to close
else if (isset($_POST['action']) && $_POST['action'] == 'CLOSE') {
    mysqli_query($conn, "UPDATE event SET STATUS='CLOSE' WHERE EVENTS='$evnt'");
    header("Location: events.php?msg=SCD");
} 

// Delete event 
else if (isset($_POST['action']) && $_POST['action'] == 'DELETE') {
    mysqli_query($conn, "DELETE FROM event WHERE EVENTS='$evnt'");
    header("Location: events.php?msg=DD");
}

// Add new event
else if (isset($_POST['action']) && $_POST['action'] == 'ADD') {
    $event  = $_POST["event"];
    $dep    = $_POST["dep"];
    $status = $_POST["status"];
    $date   = $_POST["date"];
    $ven    = $_POST["venue"];
    $type   = $_POST['type'];
    $team   = $_POST['team'];
    $maxmem = $_POST['max-mem'];

    $date   = str_replace("T", " ", "$date");

    $insert = "INSERT INTO event ( EVENTS, TYPE, DEPARTMENT, STATUS, TEAM, MAX_MEM, DATE, VENUE) VALUES ('$event','$type','$dep','$status', '$team', '$maxmem', '$date', '$ven')";
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM event WHERE EVENTS='$event'")) == 0) {
        mysqli_query($conn, $insert);
        header("Location: events.php?msg=AD");
    } else {
        header("Location: events.php?msg=exist");
    }
}

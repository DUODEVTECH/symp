<?php
session_start();
include "../config.php";
include "../sympDetail.php";

function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function check($conn, $id) {
    $check = mysqli_query($conn, "SELECT ID FROM users WHERE ID='$id'");
    if (mysqli_num_rows($check) == 1)
        return $id;
    else
        return 0;
}

if (isset($_POST['submit'])) {
    $event  = validate($_POST['event']);
    $first  = check($conn, validate($_POST['first']));
    $second = check($conn, validate($_POST['second']));
    $third  = check($conn, validate($_POST['third']));

    if ($first == 0 || $second == 0 || $third == 0) {
        header("Location:prizeSelect.php?msg=notFound");
    } else {
        mysqli_query($conn, "UPDATE event SET FIRST='$first', SECOND='$second', THIRD='$third' WHERE EVENTS='$event'");
        header("Location: prizeSelect.php?msg=done");
    }
}

<?php
session_start();
include "config.php";

$evt = $_SESSION['EVE'];

if (isset($_POST['submit'])) {

    if (!empty($_FILES['file']['name']) && ($_FILES['file']['type'] == "text/csv" || $_FILES['file']['type'] == "application/vnd.ms-excel")) {
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            fgetcsv($csvFile);
            $num = mysqli_num_rows(mysqli_query($conn, "SELECT ID FROM users ORDER BY ID DESC LIMIT 1"));
            $update = 0;
            $insert = 0;

            while (($line = fgetcsv($csvFile)) !== FALSE) {
                $num++;
                $id   = sprintf("ESEC%04d", $num);

                $name     = strtoupper($line[0]);
                $email    = strtolower($line[1]);
                $phone    = $line[2];
                $clg      = strtoupper($line[4]);
                $clg_roll = strtoupper($line[5]);
                $deg      = strtoupper($line[6]);
                $dep      = strtoupper($line[7]);
                $year     = strtoupper($line[8]);
                $pass     = "esec@123";

                $check = mysqli_query($conn, "SELECT ID FROM users WHERE EMAIL='{$email}'");

                if (mysqli_num_rows($check) > 0) {
                    mysqli_query($conn, "UPDATE users SET NAME='$name', EMAIL='$email', PHONE='$phone', COLLEGE='$clg', CLG_ROLL='$clg_roll', DEGREE='$deg', DEPARTMENT='$dep', YEAR='$year'");
                    $update++;
                } else {
                    mysqli_query($conn, "INSERT INTO users (ID, NAME, EMAIL, PHONE, PASS, COLLEGE, CLG_ROLL, DEGREE, DEPARTMENT, YEAR) VALUES ('$id','$name','$email','$phone','$pass','$clg','$clg_roll','$deg','$dep','$year')");
                    $insert++;
                }
            }
            if ($evt == "admin") {
                header("Location:admin/userList.php?msg=done&in=$insert&up=$update");
            } else {
                header("Location:coordinator/userList.php?msg=done&in=$insert&up=$update");
            }
        }
    } else {
        if ($evt == "admin") {
            header("Location:admin/userList.php?msg=notsupport");
        } else {
            header("Location:coordinator/userList.php?msg=notsupport");
        }
    }
}

<?php
session_start();
include "config.php";

$eve = $_SESSION['EVE'];
if ($eve != "ENTIRE EVENT" && $eve != "admin") {
    $res = mysqli_query($conn, "SELECT * FROM users INNER JOIN user_reg_event ON users.ID=user_reg_event.SYMPID WHERE user_reg_event.EVENT='$eve' ORDER BY users.ID");
} else {
    $res = mysqli_query($conn, "SELECT * FROM users ORDER BY ID");
}

$filename = "Registered-Student-List-" . date("Y-m-d") . ".csv";
if (mysqli_num_rows($res) == 0) {
    $html = "ID,NAME,PHONE,COLLEGE ROLL NO,YEAR,DEPARTMENT,COLLEGE\n\nNo students registered.";

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    echo $html;
} else {

    $html = "ID,NAME,PHONE,EMAIL,COLLEGE ROLL NO,YEAR,DEPARTMENT,COLLEGE\n";

    while ($row = mysqli_fetch_assoc($res)) {
        $html .= $row['ID'] . ',' . $row['NAME'] . ',' . $row['PHONE'] . ',' . $row['EMAIL'] . ',' . $row['CLG_ROLL'] . ',' . $row['YEAR'] . ',' . $row['DEPARTMENT'] . ',' . $row['COLLEGE'] . ',' . "\n";
    }
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    echo $html;
}

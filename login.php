<?php
session_start();
include "config.php";
include "mail.php";
include "sympDetail.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

$uname = validate($_POST['uname']);
$pass = validate($_POST['password']);

if ($uname == '') {
    header("Location: index.php?msg=err");
} else if ($pass == '') {
    header("Location: index.php?msg=error");
}

$user            = "SELECT * FROM users WHERE EMAIL='$uname' AND PASS='$pass'";
$co_ordi         = "SELECT * FROM coordinator WHERE EMAIL='$uname' AND PASS='$pass'";
$admin           = "SELECT * FROM admin WHERE EMAIL='$uname' AND PASS='$pass'";
$user_result     = mysqli_query($conn, $user);
$co_ordi_result  = mysqli_query($conn, $co_ordi);
$admin_result    = mysqli_query($conn, $admin);

// User login validation
if (mysqli_num_rows($user_result) === 1) {
    $row = mysqli_fetch_assoc($user_result);

    if ($row["EMAIL"] === $uname && $row['PASS'] === $pass) {
        $_SESSION['EMAIL'] = $row['EMAIL'];
        $_SESSION['NAME'] = $row['NAME'];
        $_SESSION['ID'] = $row['ID'];
        $_SESSION['privilage'] = "user";
        $_SESSION['log'] = 1;
        $_SESSION['last_sign'] = time();

        if ($row['VERIFY'] == 0) {
            $code = rand(100000, 999999);

            $mail->setFrom( $sympEmail, $sympName." ".$sympYear);
            $mail->addAddress($row['EMAIL'], $row['NAME']);
            $mail->isHTML(true);

            $mail->Subject = "OTP Verification Code";
            $mail->Body = "<span style='text-align:center; font-size: 13px;'>Your verification code for verify your account in Symposium registration is " . $code . "</span>";

            mysqli_query($conn, "UPDATE users SET OTP='$code' WHERE ID='{$row['ID']}'");

            if ($mail->send()) {
                header("Location: verify_mail.php");
            }
        } else {
            header("Location: user/participant.php");
        }

        exit();
    } else {
        header("Location: index.php?msg=failed");
    }
} else if (mysqli_num_rows($co_ordi_result) === 1) {
    $row = mysqli_fetch_assoc($co_ordi_result);

    if ($row['EMAIL'] === $uname && $row['PASS'] === $pass) {
        $_SESSION['EMAIL'] = $row['EMAIL'];
        $_SESSION['NAME'] = $row['NAME'];
        $_SESSION['ID'] = $row['ROLLNO'];
        $_SESSION['POSITION'] = $row['POSITION'];
        $_SESSION['EVE'] = $row['EVENT'];
        $_SESSION['privilage'] = "coordinator";
        $_SESSION['log'] = 1;
        $_SESSION['last_sign'] = time();

        header("Location: coordinator/coordinator.php");
        exit();
    } else {
        header("Location: index.php?msg=failed");
    }
} else if (mysqli_num_rows($admin_result) === 1) {
    $row = mysqli_fetch_assoc($admin_result);

    if ($row['EMAIL'] === $uname && $row['PASS'] === $pass) {

        $_SESSION['EMAIL'] = $row['EMAIL'];
        $_SESSION['NAME'] = $row['NAME'];
        $_SESSION['ID'] = $row['ID'];
        $_SESSION['EVE'] = "admin";
        $_SESSION['privilage'] = "admin";
        $_SESSION['log'] = 1;
        $_SESSION['last_sign'] = time();

        header("Location: admin/admin.php");
        exit();
    } else {
        header("Location: index.php?msg=failed");
    }
} else if (mysqli_num_rows($user_result) == 0 && mysqli_num_rows($co_ordi_result) == 0 && mysqli_num_rows($admin_result) == 0) {
    header("Location: index.php?msg=failed");
}

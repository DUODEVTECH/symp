<?php
session_start();
include "config.php";
include "mail.php";
include "sympDetail.php";

if (isset($_SESSION['ID'])) {
    $id = $_SESSION['ID'];
    $res = mysqli_query($conn, "SELECT NAME, EMAIL FROM users WHERE ID='$id'");

    if (mysqli_num_rows($res) > 0) {
        $user = mysqli_fetch_assoc($res);
        $email = $user['EMAIL'];
    }
}
$email = $_SESSION['EMAIL'];
$table = $_SESSION['table'];

$code = rand(100000, 999999);

$mail->setFrom( $sympEmail, $sympName." ".$sympYear);
$mail->addAddress($email);
$mail->isHTML(true);

$mail->Subject = "OTP Verification Code";
$mail->Body = "<span style='text-align:center; font-size: 13px;'>Your verification code for verify your account in Symposium registration is " . $code . "</span>";

mysqli_query($conn, "UPDATE {$table} SET OTP='$code' WHERE ID='$id'");

if ($mail->send()) {
    header("Location: verify_mail.php");
}

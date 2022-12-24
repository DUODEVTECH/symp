<?php
session_start();
include "config.php";
include "mail.php";
include "sympDetail.php";

function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$name     = strtoupper(validate($_POST['name']));
$clg_roll = strtoupper(validate($_POST['clg_roll']));
$email    = strtolower(validate($_POST['email']));
$phone    = validate($_POST['phone']);
$clg      = strtoupper(validate($_POST['clg']));
$dep      = strtoupper(validate($_POST['dep']));
$deg      = strtoupper(validate($_POST['deg']));
$year     = strtoupper(validate($_POST['year']));
$pass     = validate($_POST['password']);

$sql    = "SELECT * FROM users WHERE EMAIL = '$email' LIMIT 1";
$insert = "INSERT INTO users (ID, NAME, EMAIL, PHONE, PASS,  COLLEGE, DEPARTMENT, DEGREE, YEAR,CLG_ROLL) VALUES (?,?,?,?,?,?,?,?,?,?)";

$result = mysqli_query($conn, $sql);
$res = mysqli_query($conn, "SELECT ID FROM users ORDER BY ID DESC LIMIT 1");
$lastID    = mysqli_fetch_assoc($res);
if ($lastID['ID'] != null) {
    $num = (int)substr($lastID['ID'], -4);
    $num++;
    $id = sprintf("ESEC%04d", $num);
} else {
    $id = "ESEC0001";
}
if (mysqli_num_rows($result) === 0) {
    $stmt = $conn->prepare($insert);
    $stmt->bind_param('ssssssssss', $id, $name, $email, $phone, $pass, $clg, $dep, $deg, $year, $clg_roll);
    $stmt->execute();
    $_SESSION['NAME'] = $name;
    $_SESSION['EMAIL'] = $email;
    $_SESSION['ID'] = $id;
    $_SESSION['privilage'] = "user";

    $code = rand(100000, 999999);

    $mail->setFrom( $sympEmail, $sympName." ".$sympYear);
    $mail->addAddress($email, $name);
    $mail->isHTML(true);

    $mail->Subject = "OTP Verification Code";
    $mail->Body = "<br><span style='text-align:center; font-size: 13px;'>Your verification code for verify your account in Symposium registration is " . $code . "</span>";

    mysqli_query($conn, "UPDATE users SET OTP='$code' WHERE ID='$id'");

    if ($mail->send()) {
        header("Location: verify_mail.php");
    }
} else {
    header("Location: index.php?msg=exist");
}

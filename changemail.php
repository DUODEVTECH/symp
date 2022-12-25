<?php
session_start();
include "config.php";
include "mail.php";
include "sympDetail.php";

if (isset($_SESSION['EMAIL'])) {
    $preEmail = $_SESSION['EMAIL'];
}
if (isset($_POST['submit'])) {
    $newEmail = $_POST['newemail'];
    mysqli_query($conn, "UPDATE users SET EMAIL='$newEmail' WHERE EMAIL='$preEmail'");
    $_SESSION['EMAIL'] = $newEmail;

    $code = rand(100000, 999999);

    $mail->setFrom( $sympEmail, $sympName." ".$sympYear);
    $mail->addAddress($newEmail);
    $mail->isHTML(true);

    $mail->Subject = "OTP Verification Code";
    $mail->Body = "<span style='text-align:center; font-size: 13px;'>Your verification code for verify your account in Symposium registration is " . $code . "</span>";

    mysqli_query($conn, "UPDATE users SET OTP='$code' WHERE ID='$id'");

    if ($mail->send()) {
        header("Location: verify_mail.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Mail</title>
    <link rel="icon" href="img/logo/title_logo.png">
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
</head>

<body>
    <div class="logo-img" style="margin-top: 90px;">
        <img src="img/logo/logo.png" alt="College logo">
        <img src="img/logo/naac.png" alt="NAAC logo">
    </div>
    <h1 style="margin-top: 80px;"><a href="https://erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
            <h3>(An Autonomous Institution)</h3>
        </a></h1><br>
    <h2 class="logo"><?php echo $sympName; ?> <span><?php echo $sympYear; ?></span></h2><br>
    <div class="forget_box">
        <br>
        <h3>Change Mail ID</h3>
        <?php
        if (isset($error['msg']) && $error['msg'] == 'notexist') {
            echo "<span id='errMsg'>You are not registered for event. Please register first.</span><br>";
        }
        unset($error);

        ?>
        <form method="post" class="form">
            <span>Your previous Email - <strong><?php echo $preEmail; ?></strong></span>
            <br><input type="email" name="newemail" placeholder="E-mail ID" autocomplete="off" required><br><br>
            <button type="submit" name="submit">Change E-Mail</button>
        </form>
    </div>
</body>

</html>
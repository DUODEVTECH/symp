<?php
session_start();
include "../mail.php";
include "../config.php";
include "../sympDetail.php";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $code = rand(100000, 999999);

    $user = mysqli_query($conn, "SELECT * FROM users WHERE EMAIL='$email'");
    $co = mysqli_query($conn, "SELECT * FROM coordinator WHERE EMAIL='$email'");

    $mail->setFrom( $sympEmail, $sympName.' '.$sympYear);
    $mail->addAddress($email);
    $mail->isHTML(true);

    $mail->Subject = "OTP Verification Code";
    $mail->Body = "<span>Your verification code for reset your password is " . $code . "</span>";


    if (mysqli_num_rows($user) > 0) {

        mysqli_query($conn, "UPDATE users SET OTP='$code' WHERE EMAIL='$email'");

        if (!$mail->send()) {
            echo "Error Message : " . $mail->ErrorInfo;
        } else {
            $_SESSION['EMAIL'] = $email;
            $_SESSION['table'] = "users";
            header("Location: otp_check.php");
        }
    } else if (mysqli_num_rows($co) > 0) {

        mysqli_query($conn, "UPDATE coordinator SET OTP='$code' WHERE EMAIL='$email'");

        if ($mail->send()) {
            $_SESSION['EMAIL'] = $email;
            $_SESSION['table'] = "coordinator";
            header("Location: otp_check.php");
        }
    } else {
        $error['msg'] = "notexist";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="icon" href="../img/logo/title_logo.png">
    <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
</head>

<body>
    <div class="logo-img" style="margin-top: 90px;">
        <img src="img/logo/logo.png" alt="College logo">
        <img src="img/logo/naac.png" alt="NAAC logo">
    </div>
    <h1 style="margin-top: 80px;"><a href="https://www.erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
            <h3>(An Autonomous Institution)</h3>
        </a></h1><br>
    <h2 class="logo"><?php echo $sympName; ?> <span><?php echo $sympYear; ?></span></h2><br>
    <div class="forget_box">
        <br>
        <h3>Reset Password</h3>
        <?php
        if (isset($error['msg']) && $error['msg'] == 'notexist') {
            echo "<span id='errMsg'>You are not registered for event. Please register first.</span><br>";
        }
        unset($error);

        ?>
        <form method="post" class="form">
            <br><input type="email" name="email" placeholder="E-mail ID" autocomplete="off" required><br><br>
            <button type="submit" name="submit">Send OTP</button>
        </form>
    </div>
</body>

</html>
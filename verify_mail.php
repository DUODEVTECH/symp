<?php
session_start();
include "config.php";
include "sympDetail.php";

$email = $_SESSION['EMAIL'];

if (isset($_POST['submit'])) {
    $code = $_POST['otp'];

    $res = mysqli_query($conn, "SELECT OTP FROM users WHERE EMAIL='$email'");
    $row = mysqli_fetch_assoc($res);

    if (mysqli_num_rows($res) > 0) {
        if ($code == $row['OTP']) {
            mysqli_query($conn, "UPDATE users SET VERIFY='1' WHERE EMAIL='$email'");
            header("Location: user/participant.php");
        } else
            $error['msg'] = "wrong";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Registered Mail</title>
    <link rel="icon" href="img/logo/title_logo.png">
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
</head>

<body>
    <h1 style="margin-top: 80px;"><a href="https://www.erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
            <h3>(An Autonomous Institution)</h3>
        </a></h1><br>
    <h2 class="logo"><?php echo $sympEmail; ?> <span><?php echo $sympYear; ?></span></h2><br>
    <div class="forget_box">
        <br>
        <h3>OTP Verification</h3>
        <?php
        if (isset($error['msg']) && $error['msg'] == 'wrong') {
            echo "<span id='errMsg'>Incorrect OTP.</span><br>";
        }
        unset($error);
        ?>
        <span id="sucMsg">Please verify your E-Mail Id before Log In</span>

        <form method="post" class="form">
            <span>We've sent a verification code to your email - <strong><?php echo $email; ?></strong> <a href="changemail.php">Change</a></span>
            <br><input type="number" name="otp" placeholder="Enter OTP" autocomplete="off" required><br><br>
            <button type="submit" name="submit">Verify</button><br><br>
            <span>Not yet received ? <a href="resendOTP.php">Resend OTP</a></span>
        </form>
    </div>
</body>

</html>
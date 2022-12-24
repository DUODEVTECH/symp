<?php
session_start();
include "../config.php";
include "../sympDetail.php";

$error = array();
$email = $_SESSION['EMAIL'];
$table = $_SESSION['table'];

if (isset($_POST['submit'])) {
    $code = $_POST['otp'];

    $res = mysqli_query($conn, "SELECT OTP FROM {$table} WHERE EMAIL='$email'");
    $row = mysqli_fetch_assoc($res);

    if (mysqli_num_rows($res) > 0) {
        if ($code == $row['OTP'])
            header("Location: reset_password.php");
        else
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
        <h3>OTP Verification</h3>
        <?php
        if (isset($error['msg']) && $error['msg'] == 'wrong') {
            echo "<span id='errMsg'>Incorrect OTP.</span><br>";
        }
        unset($error);
        ?>
        <form method="post" class="form">
            <span>We've sent a verification code to your email - <span style="font-weight:bolder"><?php echo $email; ?></span></span>
            <br><input type="number" name="otp" placeholder="Enter OTP" autocomplete="off" required><br><br>
            <button type="submit" name="submit">Verify</button>
            <span>Not yet received ? <a href="../resendOTP.php">Resend OTP</a></span>
        </form>
    </div>
</body>

</html>
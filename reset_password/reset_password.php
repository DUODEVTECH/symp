<?php
session_start();
include "../config.php";
include "../sympDetail.php";

$email = $_SESSION['EMAIL'];
$table = $_SESSION['table'];

if (isset($_POST['submit'])) {
    $pass = $_POST['pass'];
    $rpass = $_POST['rpass'];
    if ($pass == $rpass) {
        mysqli_query($conn, "UPDATE $table SET PASS='$pass' WHERE EMAIL='$email'");

        session_unset();
        session_destroy();

        header("Location:../index.php?msg=passResetDone");
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

    <h1 style="margin-top: 80px;"><a href="https://erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
            <h3>(An Autonomous Institution)</h3>
        </a></h1><br>
    <h2 class="logo"><?php echo $sympName; ?> <span><?php echo $sympYear; ?></span></h2><br>
    <div class="forget_box">
        <br>
        <h3>Reset Password</h3>
        <?php
        if (isset($error['msg']) && $error['msg'] == 'notmatch') {
            echo "<span id='errMsg'>Password and Confirm password doesn't match.</span><br>";
        }
        unset($error);
        ?>
        <form method="post" class="form">
            <br><input type="password" name="pass" placeholder="Enter new password" autocomplete="off" required><br>
            <input type="password" name="rpass" placeholder="Confirm new password" autocomplete="off" required><br><br>
            <button type="submit" name="submit">Reset</button>
        </form>
    </div>
</body>

</html>
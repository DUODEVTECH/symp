<?php
session_start();
include "../autologout.php";
include "../sympDetail.php";

if (isset($_SESSION['EMAIL']) && isset($_SESSION['NAME']) && isset($_SESSION['privilage']) && $_SESSION['privilage'] == "coordinator") {
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../img/logo/title_logo.png">
        <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/d66f5928de.js" crossorigin="anonymous"></script>
        <title>About - User</title>
    </head>
    <body>
        <div class="navigation"></div>

        <div class="logo-img" style="margin-top: 90px;">
            <img src="../img/logo/logo.png" alt="College logo">
            <img src="../img/logo/naac.png" alt="NAAC logo">
        </div>

        <h1 style="margin-top: 80px;"><a href="https://erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
                <h3>(An Autonomous Institution)</h3>
            </a></h1><br>
        <h2 class="logo"><?php echo $sympName; ?> <span><?php echo $sympYear; ?></span></h2><br>

        <h3>ABOUT</h3>
        <br><br><br>

        <div class="about">
            <div class="about-items">
                <div class="img">
                    <img src="../img/logo/logo.png?<?php echo time(); ?>" alt="img" />
                </div>
                <div class="con">
                    <h2 style="color: white;">ESEC</h2>
                    <br />
                    <p id="para">Vision of<b> Erode Sengunthar Engineering college</b> is to become a world class Technical Institution and Scientific Research centre for the Benefit of the Society</p>
                </div>
            </div>
            <div class="about-items">
                <div class="img">
                    <img src="../img/logo/about_img.jpg" alt="img" style="width: 200px" />
                </div>
                <div class="con">
                    <h2 class="logo" style="color: white;"><?php echo $sympName; ?> <span><?php echo $sympYear; ?></span></h2><br>
                    <br />
                    <p id="para"><?php echo $sympVision; ?></p>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $(".navigation").load("navbarCO.php");
                window.setTimeout(function() {
                    $(".navigation > ul > li.about").addClass("active");
                }, 700);
            });
        </script>
    </body>
    </html>

<?php
} else {
    session_unset();
    session_destroy();
    header("Location: ../index.php?msg=ReLogin");
    exit();
}

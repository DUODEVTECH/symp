<?php
session_start();
include "../autologout.php";
include "../sympDetail.php";

if (isset($_SESSION['EMAIL']) && isset($_SESSION['NAME']) && isset($_SESSION['privilage']) && $_SESSION['privilage'] == "admin") {
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
        <title>About - Admin</title>
    </head>

    <body class="admin-panel">


        <div class="navigation-admin"></div>

        <div class="wrapper">

            <?php 
            if(isset($_GET['msg']) && $_GET['msg'] == "abt"){
				echo "<span id='sucMsg'>Vision updated successfully.</span>";
			}
            ?>

            <div class="logo-img" style="margin-top: 90px;">
                <img src="../img/logo/logo.png" alt="College logo">
                <img src="../img/logo/naac.png" alt="NAAC logo">
            </div>

            <h1 style="margin-top: 80px;">
                <a href="https://erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
                    <h3>(An Autonomous Institution)</h3>
                </a>
            </h1><br>
            <h2 class="logo"><?php echo $sympName." <span>".$sympYear ?></span></h2><br>

            <h3>ABOUT EDIT</h3>
            <br><br><br>

            <h3>PREVIEW</h3>
            <div class="about">
                <div class="about-items">
                    <div class="img">
                        <img src="../img/logo/logo.png?<?php echo time(); ?>" alt="img" />
                    </div>
                    <div class="con">
                        <h2 style="color: white;">ESEC</h2>
                        <br />
                        <p id="para">
                            Vision of
                            <b> Erode Sengunthar Engineering college</b> is to
                            become a world class Technical Institution and
                            Scientific Research centre for the Benefit of the
                            Society
                        </p>
                    </div>
                </div>
                <div class="about-items">
                    <div class="img">
                        <img src="../img/logo/about_img.jpg" alt="img" style="width: 200px;" />
                    </div>
                    <div class="con">
                        <h2 class="logo" style="color: white;"><?php echo $sympName." <span>".$sympYear ?></span></h2><br>
                        <br />
                        <p id="para"><?php echo $sympVision; ?></p>
                    </div>
                </div>
            </div>

            <div class="about-edit">
                <h3>EDIT</h3>
                <form action="symposiumInfoUpdate.php" method="post" class="form">
                    <div class="input-group">
                        <label for="symp-vision">Vision of Symposium:</label>
                        <textarea name="symp-vision" id="symp-vision" cols="20" rows="5"></textarea>
                    </div>
                    <input type="hidden" name="page" value="1">
                    <button type="submit" name="save-btn" value="about">SAVE</button>
                </form>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $(".navigation-admin").load("navbaradmin.php");
                window.setTimeout(function() {
                    $(".navigation-admin > ul > li.about").addClass("active");
                }, 700);
            });
        </script>
    </body>
    </html>

<?php
} else {
    session_unset();
    session_destroy();
    header("Location:../index.php?msg=ReLogin");
    exit();
}
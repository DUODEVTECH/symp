<?php
session_start();
include "../config.php";
include "../autologout.php";
include "../sympDetail.php";

$id = $_SESSION['ID'];

if (isset($_POST['delete'])) {
    $evt = $_POST['event'];
    mysqli_query($conn, "DELETE FROM user_reg_event WHERE EVENT='$evt' AND SYMPID='$id'");
}

$check = mysqli_query($conn, "SELECT * FROM user_reg_event WHERE SYMPID='$id'");

if (isset($_SESSION['EMAIL']) && isset($_SESSION['NAME']) && isset($_SESSION['privilage']) && $_SESSION['privilage'] == "user") {
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
        <title>Registered Events - User</title>
    </head>

    <body>

        <div class="navigation"></div>

        <div class="logo-img" style="margin-top: 90px;">
            <img src="../img/logo/logo.png" alt="College logo">
            <img src="../img/logo/naac.png" alt="NAAC logo">
        </div>

        <h1 style="margin-top: 60px;"><a href="https://erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
                <h3>(An Autonomous Institution)</h3>
            </a></h1>
        <h2 class="logo"><?php echo $sympName; ?> <span><?php echo $sympYear; ?></span></h2><br>

        <h3>REGISTERED EVENTS</h3>

        <div style="overflow-x: auto;">

            <table class="evtDiv">
                <tr>
                    <th>EVENT</th>
                    <th>DELETE</th>
                </tr>
                <?php
                if (mysqli_num_rows($check) > 0) {
                    while ($row = mysqli_fetch_assoc($check)) {
                        $evt = $row['EVENT'];
                        echo "<tr>";
                        echo "<td width='80%'>" . $evt . "</td>";
                        echo "<td><form method='POST'><input name='event' value='$evt' hidden><button type='submit' name='delete' style='width:45px;height:40px'><i class='fa-sm fa-solid fa-trash-can'></i></button></form>";
                        echo "</tr>";
                    }
                } else
                    echo "No events registered.";
                ?>
            </table>
        </div>
        <script>
            $(document).ready(function() {
                $(".navigation").load("navbarUser.php");
                window.setTimeout(function() {
                    $(".navigation > ul > li.reg-event").addClass("active");
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

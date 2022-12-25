<?php
session_start();
include "../autologout.php";
include "../config.php";
include "../sympDetail.php";

$date = mysqli_fetch_assoc(mysqli_query($conn, "SELECT DATE FROM event WHERE EVENTS='$sympName'"));

if (isset($_SESSION['EMAIL']) && isset($_SESSION['NAME']) && isset($_SESSION['privilage']) && $_SESSION['privilage'] == "user") {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../img/logo/title_logo.png">
        <title>Home - User</title>
        <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/d66f5928de.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="navigation"></div>

        <?php
        if ($_SESSION['log'] == 1) {
            echo "<span id='logMsg'>LOGGED IN SUCCESSFULLY</span>";
            $_SESSION['log']++;
        }
        ?>

        <div class="logo-img" style="margin-top: 90px;">
            <img src="../img/logo/logo.png" alt="College logo">
            <img src="../img/logo/naac.png" alt="NAAC logo">
        </div>

        <h1 style="margin-top: 60px;"><a href="https://erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
                <h3>(An Autonomous Institution)</h3>
            </a></h1>
        <h2 class="logo"><?php echo $sympName; ?> <span><?php echo $sympYear; ?></span></h2><br>

        <div id="user-timer">
            <div id="timerDIV">
                <div>
                    <span id="days"></span>
                    <span>Days</span>
                </div>
                <div>
                    <span id="hour"></span>
                    <span>Hours</span>
                </div>
                <div>
                    <span id="min"></span>
                    <span>Minutes</span>
                </div>
                <div>
                    <span id="sec"></span>
                    <span>Seconds</span>
                </div>
            </div>
        </div>

        <h3>WELCOME <?php echo $_SESSION['NAME'].", Your ".$sympName." ID is : ".$_SESSION['ID']; ?></h3><br>


        <div id="celebration">
            <canvas id="canvas">Canvas is not supported in your browser.</canvas>
            <script src="../js/crackers.js"></script>
            <p id='sympDay'>
                The Symposium of Erode Sengunthar Engineering College is happening now.
                Everyone is involved in the events.
                The Symposium is open to registered students.
                Students can also register in offline mode on the event day.
            </p>
        </div>

        <div class="details">
            <p id="info">Every year, Erode Sengunthar Engineering College conducts a National Level Technical Symposium for the students.
                Students can join by registering on this website. Students can pay the registration fees only on the spot. Registration starts on October 03, 2022.</p>
            <center>
                <button><a href="eventInfo.php">Click here to register events</a></button>
            </center>
        </div>

        <center>
            <span class='note'><b>Note : </b> If you registered for Paper Presentation<br><button><a href="uploadFileIF.php">upload here</a></button></span>
        </center>


        <script>
            var date = "<?php echo $date['DATE']; ?>".replace(" ", "T");
            var countDownDate = new Date(date).getTime();
            var now = new Date().getTime();

            function eventDate() {
                var now = new Date().getTime();

                var dTag = document.getElementById("days");
                var hTag = document.getElementById("hour");
                var mTag = document.getElementById("min");
                var sTag = document.getElementById("sec");

                const second = 1000;
                const minute = second * 60;
                const hour = minute * 60;
                const day = hour * 24;

                var distance = countDownDate - now;
                const d = Math.floor(distance / day);
                const h = Math.floor((distance % day) / hour);
                const m = Math.floor((distance % hour) / minute);
                const s = Math.floor((distance % minute) / second);

                if (distance > 0) {
                    document.getElementById('user-timer').style = "display:block";
                    dTag.innerText = d;
                    hTag.innerText = h;
                    mTag.innerText = m;
                    sTag.innerText = s;
                    document.getElementById('celebration').style.display = "none";
                } else {
                    document.getElementById('user-timer').style = "display:none";
                    document.getElementById('timerDIV').style = "border:none";
                    document.getElementById('celebration').style.display = "";
                    clearInterval(timer);
                }
            }
            const timer = setInterval(function() {
                eventDate();
            }, 1000);

            window.onload = function() {
                $(".navigation").load("navbarUser.php");
                window.setTimeout(function() {
                    $(".navigation > ul > li.home").addClass("active");
                }, 1000);
            }
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

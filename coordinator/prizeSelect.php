<?php
session_start();
include "../config.php";
include "../autologout.php";
include "../sympDetail.php";

if ($_SESSION['EVE'] == "ENTIRE EVENT")
    $evt = "1=1";
else
    $evt = "EVENTS='{$_SESSION['EVE']}'";

$prize = mysqli_query($conn, "SELECT * FROM event WHERE EVENTS!='$sympName' AND STATUS='OPEN' AND " . $evt);

if (isset($_SESSION['EMAIL']) && isset($_SESSION['NAME']) && isset($_SESSION['privilage']) && $_SESSION['privilage'] == "coordinator") {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../img/logo/title_logo.png">
        <title>Prize List - Co Ordinator</title>
        <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/d66f5928de.js" crossorigin="anonymous"></script>
    </head>

    <body>

        <div class="navigation"></div>


        <?php
        if (isset($_GET["msg"]) && $_GET["msg"] == "done") {
            echo "<span id='sucMsg'>Prize list added successfully</span><br>";
        } else if (isset($_GET["msg"]) && $_GET["msg"] == "notFound") {
            echo "<span id='errMsg'>Entered ID not found</span><br>";
        }
        ?>

        <div class="logo-img" style="margin-top: 90px;">
            <img src="../img/logo/logo.png" alt="College logo">
            <img src="../img/logo/naac.png" alt="NAAC logo">
        </div>

        <h1 style="margin-top: 80px;"><a href="https://www.erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
                <h3>(An Autonomous Institution)</h3>
            </a></h1><br>
        <h2 class="logo"><?php echo $sympName.' <span>'.$sympYear; ?></span></h2><br>
        <h3>Prize List</h3><br>

        <div class="event-prize-list"> </div>

        <?php
        if (mysqli_num_rows($prize) > 0) {
            $i = 10;
            while ($evePrize = mysqli_fetch_assoc($prize)) {
                if ($evePrize['FIRST'] != NULL && $evePrize['SECOND'] != NULL && $evePrize['THIRD'] != NULL) {
                    $event_prize = "<div class='event-prize'><h4>{$evePrize['EVENTS']}</h4><div class='prize-list'  id='$i'><p >{$evePrize['FIRST']}</p><p>{$evePrize['SECOND']}</p><p>{$evePrize['THIRD']}</p><button onclick='prizeForm(this.parentNode.id)'>Edit</button></div><form action='updatePrize.php' method='post' autocomplete='off' class='prize-form' style='display:none;'><button type='submit' name='submit'>Update</button></form></div>";
                    $i++;
                } else {
                    $event_prize = "<div class='event-prize'><h4>{$evePrize['EVENTS']}</h4><form action='updatePrize.php' method='post' class='prize-form form' autocomplete='off'><input type='hidden' name='event' value='{$evePrize['EVENTS']}'><input type='text' name='first' placeholder='Enter First prize ID' value='{$evePrize['FIRST']}'><input type='text' name='second' placeholder='Enter Second prize ID' value='{$evePrize['SECOND']}'><input type='text' name='third' placeholder='Enter Third prize ID' value='{$evePrize['THIRD']}'><button type='submit' name='submit'>Update</button></form></div>";
                }
        ?>
                <script>
                    var event_prize = "<?php echo $event_prize; ?>";
                    $(".event-prize-list").append(event_prize);
                </script>
        <?php
            }
        }
        ?>

        <a href="sendPrizeListMail.php" class="mail"><button class="mail-btn">Send Mail</button></a>

        <script>
            function prizeForm(a) {
                var pList = ['first', 'second', 'third'];
                var placeHolder = ['Enter First prize ID', 'Enter Second prize ID', 'Enter Third prize ID'];

                for (i = 2; i >= 0; i--) {
                    var value = document.getElementById(a).childNodes[i].innerHTML;
                    var input = document.createElement("input");
                    input.value = value;
                    input.name = pList[i];
                    input.placeholder = placeHolder[i];
                    input.type = "text";
                    $("#" + a).next().prepend(input);
                }

                var event = document.getElementById(a).previousElementSibling.innerHTML;
                var input = document.createElement("input");
                input.value = event;
                input.name = "event"
                input.type = "hidden";

                $("#" + a).next().prepend(input);
                $("#" + a).css("display", "none");
                $("#" + a).next().css("display", "flex");
            }

            $(document).ready(function() {
                $(".navigation").load("navbarCO.php")
                window.setTimeout(function() {
                    $(".navigation > ul > li.prize  ").addClass("active");
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

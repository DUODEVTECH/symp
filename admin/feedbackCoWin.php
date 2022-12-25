<?php
session_start();
include "../config.php";
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
        <title>Feedback Data - Admin</title>
        <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/d66f5928de.js" crossorigin="anonymous"></script>
    </head>

    <body class="admin-panel">

        <div class="navigation-admin"></div>

        <div class="wrapper">

            <div class="logo-img" style="margin-top: 90px;">
                <img src="../img/logo/logo.png" alt="College logo">
                <img src="../img/logo/naac.png" alt="NAAC logo">
            </div>

            <h1 style="margin-top: 80px;"><a href="https://erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
                    <h3>(An Autonomous Institution)</h3>
                </a></h1><br>
            <h2 class="logo"><?php echo $sympName.' <span>'.$sympYear; ?></span></h2><br>
            <h3>FEEDBACK</h3><br>

            <div style="overflow-x: auto;">
                <table>
                    <tr>
                        <th>EVENT</th>
                        <th>DEPARTMENT</th>
                        <th>TOTAL USER</th>
                        <th>AVERAGE RATING</th>
                    </tr>

                    <?php
                    $j = 0;
                    $events = mysqli_query($conn, "SELECT DISTINCT EVENT, DEP FROM  feedback");
                    while ($event = mysqli_fetch_assoc($events)) {
                        $rate_total = 0;
                        $i = 1;
                        $rate_res = mysqli_query($conn, "SELECT * FROM feedback WHERE EVENT='{$event['EVENT']}'");
                        while ($rates = mysqli_fetch_assoc($rate_res)) {
                            $rate_total += $rates['RATING'];
                            $i++;
                        }
                        $avg_rate = $rate_total / ($i - 1);
                        echo "<tr id='$j'>";
                        echo "<td class='event-name'>{$event['EVENT']}</td>";
                        echo "<td class='dep-name'>{$event['DEP']}</td>";
                        echo "<td>" . ($i - 1) . "</td>";
                        echo "<td class='rate'>" . round($avg_rate, 2) . "</td>";
                        echo "</tr>";
                        $j++;
                    }
                    ?>
                </table>
            </div>
            <br>

            <div class="form">
                <button onclick="findwin()">FIND WINNER</button>
            </div>

            <div id="winner" style="display: none;">
                <table>
                    <tr id='ev'>
                        <th>EVENT NAME</th>
                        <td></td>
                    </tr>
                    <tr id='dp'>
                        <th>DEPARTMENT</th>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
        <script>
            function findwin() {
                rateList = document.getElementsByClassName('rate');
                var win = 0;
                for (i = 0; i < rateList.length; i++) {
                    if (win < rateList[i].innerHTML) {
                        win = rateList[i].innerHTML;
                        j = i;
                    }
                }
                var winner = $("tr#" + j + " > td.event-name").text();
                var windep = $("tr#" + j + " > td.dep-name").text();
                document.getElementById('winner').style.display = "block";
                document.getElementById('winner').querySelector("table #ev td").innerHTML = winner;
                document.getElementById('winner').querySelector("table #dp td").innerHTML = windep;
            }

            $(document).ready(function() {
                $(".navigation-admin").load("navbaradmin.php")
                window.setTimeout(function() {
                    $(".navigation-admin > ul > li.feedback").addClass("active");
                }, 700);
            });
        </script>

        <br><br><br><br><br>
    </body>

    </html>

<?php
} else {
    session_unset();
    session_destroy();
    header("Location:../index.php?msg=ReLogin");
    exit();
}

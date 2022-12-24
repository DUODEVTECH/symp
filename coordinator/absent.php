<?php
session_start();
include "../config.php";
include "../autologout.php";
include "../sympDetail.php";

$err = 0;
if ($_SESSION['EVE'] == "ENTIRE EVENT")
    $evt = "1=1";
else
    $evt = "EVENTS='{$_SESSION['EVE']}'";


$sql = $_SESSION['EVE'] == 'ENTIRE EVENT' ? "SELECT * FROM users INNER JOIN user_reg_event as evtReg ON users.ID=evtReg.SYMPID WHERE evtReg.ATTENDANCE='ABSENT'" : "SELECT * FROM users INNER JOIN user_reg_event as evtReg ON users.ID=evtReg.SYMPID WHERE evtReg.EVENT='{$_SESSION['EVE']}' AND evtReg.ATTENDANCE='ABSENT'";
$user = mysqli_query($conn, $sql);


if (isset($_SESSION['EMAIL']) && isset($_SESSION['NAME']) && isset($_SESSION['privilage']) && $_SESSION['privilage'] == "coordinator") {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../img/logo/title_logo.png">
        <title>Absent List - Co Ordinator</title>
        <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/d66f5928de.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="navigation"></div>


        <?php
        if (isset($_GET['msg']) && $_GET['msg'] == "done") {
            echo "<span id='sucMsg'>Absent marked successfully</span>";
        } else if (isset($_GET['msg']) && $_GET['msg'] == "notReg" && isset($_GET['id'])) {
            parse_str($_SERVER['QUERY_STRING'], $query);
            $err = "<span id='errMsg'>{$query['id']} is not registered ";
            for ($i = 0; $i < (count($query) - 2); $i++)
                $err .= $query["{$i}"] . ", ";
            echo $err . "</span>";
        } else if (isset($_GET['msg']) && $_GET['msg'] == "nouser") {
            echo "<span id='errMsg'>User not found.</span>";
        } else if (isset($_GET['msg']) && $_GET['msg'] == "emp") {
            echo "<span id='errMsg'>ID field is empty. Please type any ID.</span>";
        } else if (isset($_GET['msg']) && $_GET['msg'] == "present") {
            echo "<span id='sucMsg'>Present marked successfully</span>";
        } else if (isset($_GET['msg']) && $_GET['msg'] == "nocheck"){
            echo "<span id='errMsg'>No events selected</span>";
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
        <h3>ABSENTEES</h3>
        <br>

        <div class="absent-list">
            <form action="updateAbsent.php" method="post" autocomplete="off" class="form" required>
                <input type='text' name='id' placeholder='Enter ID of user' onchange='validate(this)' required><br>
                <div class="event-check-box">

                    <?php
                $events = mysqli_query($conn, "SELECT EVENT_ID,EVENTS FROM event WHERE EVENTS!='$sympName' AND {$evt}");
                if (mysqli_num_rows($events) > 0) {
                    while ($event = mysqli_fetch_assoc($events)) {
                        $eventList = "<input type='checkbox' name='event[]' id='event-{$event['EVENT_ID']}' value='{$event['EVENT_ID']}'><label for='event-{$event['EVENT_ID']}'>{$event['EVENTS']}<label><br>";
                        echo $eventList;
                    }
                }
                ?>
                </div>  
                <br><button type="submit" name="submit" id="absent">SAVE</button>
            </form>
        </div>

        <h3>ABSENTEES LIST</h3>

        <div style="overflow-x:auto">
            <table>
                <tr>
                    <th>S.NO</th>
                    <th>SYMP ID</th>
                    <th>NAME</th>
                    <th>MOBILE</th>
                    <th>EVENT</th>
                    <th>ATTENDANCE</th>
                    <th>PRESENT</th>
                </tr>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_assoc($user)) {
                    echo "<tr>";
                    echo "<td>$i</td>";
                    echo "<td>{$row['ID']}</td>";
                    echo "<td>{$row['NAME']}</td>";
                    echo "<td>{$row['PHONE']}</td>";
                    echo "<td>{$row['EVENT']}</td>";
                    echo "<td>{$row['ATTENDANCE']}</td>";
                    echo "<td><form method='post' action='updateAbsent.php'><button type='submit' name='present'><input type='hidden' name='id' value='{$row['SYMPID']}'><input type='hidden' name='event' value='{$row['EVENT']}'><i class='fa-solid fa-check'></i></button></form</td>";
                    echo "</tr>";
                    $i++;
                } ?>
            </table>
        </div>
        <br><br><br><br>
        <script>
            $(document).ready(function() {
                $(" .navigation").load("navbarCO.php");
                window.setTimeout(function() {
                    $(".navigation> ul > li.absent").addClass("active");
                }, 700);
            });

            function validate(input) {
                ab = document.getElementById("absent");
                if (input.value.replace(/\s+/g, '').length == 0) {
                    $("body").append("<span id='errMsg'>Enter valid details</span>")
                    ab.disabled = true;
                } else {
                    ab.disabled = false;
                }
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
?>
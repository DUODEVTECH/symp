<?php
session_start();
include "../config.php";
include "../autologout.php";
include "../sympDetail.php";

$evt = $_SESSION['EVE'];
if ($evt == "ENTIRE EVENT" || $_SESSION['POSITION'] == "FACULTY") {
    $event = mysqli_query($conn, "SELECT * FROM event");
    $evt = 'EVENTS';
} else {
    $event = mysqli_query($conn, "SELECT * FROM event WHERE EVENTS='$evt'");
}

if (isset($_SESSION['EMAIL']) && isset($_SESSION['NAME']) && isset($_SESSION['privilage']) && $_SESSION['privilage'] == "coordinator") {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Events List - Co Ordinator</title>
        <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/d66f5928de.js" crossorigin="anonymous"></script>
        <link rel="icon" href="../img/logo/title_logo.png">
    </head>

    <body>
        <div class="navigation"></div>

        <div class="logo-img" style="margin-top: 90px;">
            <img src="../img/logo/logo.png" alt="College logo">
            <img src="../img/logo/naac.png" alt="NAAC logo">
        </div>

        <h1 style="margin-top: 80px;"><a href="https://www.erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
                <h3>(An Autonomous Institution)</h3>
            </a></h1><br>
        <h2 class="logo"><?php echo $sympName.' <span>'.$sympYear; ?></span></h2><br>
        <h3>EVENTS LIST</h3><br>

        <?php
        if (isset($_GET["msg"]) && $_GET["msg"] == "ED") {
            echo "<span id='sucMsg'>Event edited successfully</span><br>";
        } else if (isset($_GET["msg"]) && $_GET["msg"] == "SOD") {
            echo "<span id='sucMsg'>Event opened successfully</span><br>";
        } else if (isset($_GET["msg"]) && $_GET["msg"] == "SCD") {
            echo "<span id='sucMsg'>Event closed successfully</span><br>";
        } else if (isset($_GET["msg"]) && $_GET["msg"] == "DD") {
            echo "<span id='sucMsg'>Event deleted successfully</span><br>";
        } else if (isset($_GET["msg"]) && $_GET["msg"] == "AD") {
            echo "<span id='sucMsg'>Event added successfully</span><br>";
        } else if (isset($_GET["msg"]) && $_GET["msg"] == "exist") {
            echo "<span id='errMsg'>Event already added</span><br>";
        }
        ?>

        <div style="overflow-x: auto;">
            <table>
                <tr>
                    <th>EVENT</th>
                    <th>TYPE</th>
                    <th>DEPARTMENT</th>
                    <th>DATE</th>
                    <th>VENUE</th>
                    <th>DESCRIPTION</th>
                    <th>EDIT</th>
                    <th>STATUS</th>
                    <th>DELETE</th>
                </tr>
                <?php
                $i = 10;
                while ($row = mysqli_fetch_assoc($event)) {
                    $status = $row['STATUS'] == 'OPEN' ? 'CLOSE' : 'OPEN';
                    $str = $row['STATUS'] == 'CLOSE' ? '' : '-open';
                    $rowID = "pop-" . $i;
                    $addDesRule = $row['DESCRIPTION'] != NULL ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-xmark"></i>';
                    echo "<tr id='$i'>";
                    echo "<td onclick=\"popup('$rowID')\">{$row['EVENTS']}</td>";
                    echo "<td>{$row['TYPE']}</td>";
                    echo "<td>{$row['DEPARTMENT']}</td>";
                    echo "<td>{$row['DATE']}</td>";
                    echo "<td>{$row['VENUE']}</td>";
                    echo "<td>{$addDesRule}</td>";
                    echo "<td><button data-id='{$row['EVENTS']}' onclick='showEdit(this.parentNode.parentNode.id,this)'><i class='fa-solid fa-pen-to-square'></i></button></td>";
                    echo "<form method='post' action='eventAct.php'><td><button type='submit' name='action' value='{$status}'><input type='hidden' name='evnt' value='{$row['EVENTS']}'><i class='fa-solid fa-lock{$str}'></i></button></td>";
                    echo "<td><button type='submit' name='action' value='DELETE'><input type='hidden' name='evnt' value='{$row['EVENTS']}'><i class='fa-solid fa-trash-can'></i></button></td></form>";
                    echo "</tr>";
                    echo "<div id='pop-$i' class='pop'>";
                    echo "<button onclick=\"popup('$rowID')\" class='cls-btn'><i class='fa-solid fa-lg fa-xmark'></i></button>";
                    echo "<div class='tabcontent' id='des'>";
                    echo "<h4>DESCRIPTION</h4>";
                    echo "<p>&nbsp;";
                    if ($row['DESCRIPTION'] != NULL)
                        echo $row['DESCRIPTION'];
                    else
                        echo "Descrition is not entered by Co-Ordinator.";
                    echo "</p>";
                    echo "</div>";
                    echo "</div>";
                    $i++;
                }
                ?>
            </table>
        </div><br>
        <p style="text-align: center; color: black;">NOTE : CLICK ON THE EVENT NAME TO SEE THE DESCRIPTION</p>
        <form action="eventAct.php" id="edit" method="POST" class="form">

            <input type="hidden" name="evnt" id="evnt"><br>
            <input type="text" name="event" placeholder="Enter Event Name" id="event" required><br>
            <select name="type" id="type" required>
                <option value="-1">Select Type</option>
                <option value="TECHNICAL">TECHNICAL</option>
                <option value="NON_TECHNICAL">NON TECHNICAL</option>
            </select><br>
            <input type="text" name="dep" placeholder="Enter Department" id="dep" required><br>
            <input type="date" name="date" placeholder="Enter Date & Time" id="date" required><br>
            <input type="text" name="venue" id="venue" placeholder="Enter Venue" required><br>
            <input type="text" name="des" id="des" placeholder="Enter Description" required><br>

            <button type="submit" name="action" value="EDIT">EDIT</button><br>
        </form><br>
        <?php
        if ($evt == "EVENTS") { ?>
            <button onclick="showAdd()" id="showAdd">ADD EVENT</button>
            <form id='add' action="eventAct.php" method="POST" class="form">
                <input type="text" name="event" placeholder="Enter Event Name" required><br>
                <select name="type" required>
                    <option value="-1">Select Type</option>
                    <option value="TECHNICAL">TECHNICAL</option>
                    <option value="NON_TECHNICAL">NON TECHNICAL</option>
                </select><br>
                <input type="date" name="date" placeholder="Enter Date & Time" required><br>
                <input type="text" name="dep" id="dep" placeholder="Enter Department"><br>
                <select name="status" id="status" required>
                    <option value="-1">SELECT STATUS</option>
                    <option value="OPEN">OPEN</option>
                    <option value="CLOSE">CLOSE</option>
                </select><br>
                <input type="text" name="venue" id="venue" placeholder="Enter Venue" required><br>

                <button type="submit" name="action" value="ADD">ADD</button><br>
            </form><br>

        <?php } ?>

        <script>
            function popup(id) {
                var div = document.getElementById(id);
                div.classList.toggle("active");
            }

            function showAdd() {
                var addForm = document.getElementById("add").style;
                addForm.display = (addForm.display == "block") ? "none" : "block";
            }

            function showEdit(tr, btn) {
                var editForm = document.getElementById("edit").style;
                editForm.display = (editForm.display == "block") ? "none" : "block";

                var evnt = document.getElementById(tr).childNodes[0].innerHTML.trim();
                var type = document.getElementById(tr).childNodes[1].innerHTML.trim();
                var dep = document.getElementById(tr).childNodes[2].innerHTML.trim();
                var date = document.getElementById(tr).childNodes[3].innerHTML.trim().replace(" ", "T");
                var ven = document.getElementById(tr).childNodes[4].innerHTML.trim();

                document.getElementById("event").value = evnt;
                document.getElementById("type").value = type;
                document.getElementById("date").value = date;
                document.getElementById("dep").value = dep;
                document.getElementById("venue").value = ven;

                document.getElementById('evnt').value = btn.getAttribute("data-id");
            }

            $(document).ready(function() {
                $(".navigation").load("navbarCO.php")
                window.setTimeout(function() {
                    $(".navigation > ul > li.eventList").addClass("active");
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

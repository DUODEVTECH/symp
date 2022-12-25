<?php
session_start();
include "../config.php";
include "../autologout.php";
include "../sympDetail.php";

$id = $_SESSION['ID'];

$date = date("yyyy-m-d") . " " . date('h:m:s');
$eventsRegistered = mysqli_query($conn, "SELECT * FROM user_reg_event WHERE SYMPID='$id' AND EVENT IN (SELECT EVENTS FROM event WHERE DATE>= CONVERT('$date',DateTime)) AND EVENT NOT IN (SELECT EVENT FROM feedback WHERE SYMPID='$id');");

function validate($data) {
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['submit'])) {
    $eventName = validate($_POST['event']);
    $feedback = validate($_POST['feedback']);

    mysqli_query($conn, "UPDATE user_reg_event SET FEEDBACK='$feedback' WHERE SYMPID='$id' AND EVENT='$eventName'");
    header("Location:userFeedback.php?msg=done");
}

if (isset($_SESSION['EMAIL']) && isset($_SESSION['NAME']) && isset($_SESSION['privilage']) && $_SESSION['privilage'] == "user") {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../img/logo/title_logo.png">
        <title>Feedback - User</title>
        <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/d66f5928de.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="navigation"></div>

        <?php
        if (isset($_GET['msg']) && $_GET['msg'] == 'done') {
            echo "<span id='sucMsg'>Your feedback has been registered.</span>";
        } ?>

        <div class="logo-img" style="margin-top: 90px;">
            <img src="../img/logo/logo.png" alt="College logo">
            <img src="../img/logo/naac.png" alt="NAAC logo">
        </div>

        <h1 style="margin-top: 80px;"><a href="https://erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
                <h3>(An Autonomous Institution)</h3>
            </a></h1><br>
        <h2 class="logo"><?php echo $sympName; ?> <span><?php echo $sympYear; ?></span></h2><br>

        <h3>Event Feedback</h3><br>

        <div class="feedback-list"> </div>
        <?php
        if (mysqli_num_rows($eventsRegistered) > 0) {
            while ($eveName = mysqli_fetch_assoc($eventsRegistered)) {
                $dep = mysqli_fetch_assoc(mysqli_query($conn, "SELECT DEPARTMENT FROM event WHERE EVENTS='{$eveName['EVENT']}'"));
                $btn = "<button onclick='openFeed(this)' data-dep='{$dep['DEPARTMENT']}'>" . $eveName['EVENT'] . "</button>";
        ?>
                <script>
                    var btn = "<?php echo $btn; ?>";
                    $(".feedback-list").append(btn);
                </script>
        <?php
            }
        } else {
            echo "<p style='text-align: center'>No events registered or started.</p>";
        }
        ?>

        <form method="post" autocomplete="off" id="feedback-form" class="form" style="display: none;" action="feedbackValidation.php">
            <input type="hidden" name="event" id="event-in"><br>
            <input type="hidden" name="dep" id="dep-in"><br>

            <div class="qn">
                <p>How the coordinator managed the event time?</p><br>
                <div class="input-rate">
                    <input type="radio" id="1" name="rate-1" value="1"><label for="1" class="rate-val">1</label>
                    <input type="radio" id="2" name="rate-1" value="2"><label for="2" class="rate-val">2</label>
                    <input type="radio" id="3" name="rate-1" value="3"><label for="3" class="rate-val">3</label>
                    <input type="radio" id="4" name="rate-1" value="4"><label for="4" class="rate-val">4</label>
                    <input type="radio" id="5" name="rate-1" value="5"><label for="5" class="rate-val">5</label>
                </div>
            </div><br>

            <button type="submit" name="submit">SUBMIT</button>
        </form>

        <script>
            function openFeed(a) {
                var event = a.innerHTML.trim();
                document.getElementById('event-in').value = event;
                var dep = $(a).attr("data-dep");
                document.getElementById('dep-in').value = dep;
                document.getElementById('feedback-form').style.display = 'block';
            }

            $(document).ready(function() {
                $(".navigation").load("navbarUser.php");
                window.setTimeout(function() {
                    $(".navigation > ul > li.feedback").addClass("active");
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

<?php
session_start();
include "../config.php";
include "../sympDetail.php";

$id  = $_SESSION['ID'];
$ppt = mysqli_query($conn, "SELECT EVENT,SYMPID FROM user_reg_event WHERE EVENT='PAPER PRESENTATION' AND SYMPID='$id'");
$res = (mysqli_num_rows($ppt) > 0) ? 1 : 0;
?>

<input type="checkbox" id="check">
<label for="check" class="checkbtn open"><i class="fa-solid fa-sm fa-bars"></i></label>
<label for="check" class="checkbtn close"><i class="fa-solid fa-sm fa-xmark"></i></label>
<ul>
    <li class="list home">
        <a href="participant.php">
            <span class="icon"><i class="fa-solid fa-sm fa-house"></i></span>
            <span class="text">HOME</span>
        </a>
    </li>
    <li class="list profile">
        <a href="userProfile.php">
            <span class="icon"><i class="fa-solid fa-sm fa-user"></i></span>
            <span class="text">PROFILE</span>
        </a>
    </li>
    <li class="list eventInfo">
        <a href="eventInfo.php">
            <span class="icon"><i class="fa-solid fa-sm fa-calendar-check"></i></span>
            <span class="text">EVENT</span>
        </a>
    </li>
    <li class="list reg-event">
        <a href="registeredEvents.php">
            <span class="icon"><i class="fa-solid fa-sm fa-list"></i></span>
            <span class="text">REGISTERED EVENTS</span>
        </a>
    </li>
    <?php
    if ($res == 1) {
    ?>
        <li class="list upload">
            <a href="uploadFileIF.php">
                <span class="icon"><i class="fa-solid  fa-sm fa-upload"></i></span>
                <span class="text">UPLOAD</span>
            </a>
        </li>
    <?php } ?>
    <li class="list feedback">
        <a href="feedback.php">
            <span class="icon"><i class="fa-solid fa-sm fa-comment"></i></span>
            <span class="text">FEEDBACK</span>
        </a>
    </li>
    <li class="list about">
        <a href="about.php">
            <span class="icon"><i class="fa-solid fa-sm fa-info"></i></span>
            <span class="text">ABOUT</span>
        </a>
    </li>
    <li class="list logout">
        <a href="../logout.php">
            <span class="icon"><i class="fa-solid fa-sm fa-right-from-bracket"></i></span>
            <span class="text">LOGOUT</span>
        </a>
    </li>
    <div class="indicator"></div>
</ul>
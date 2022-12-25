<?php
session_start();
include "../sympDetail.php";
?>
<input type="checkbox" id="check">
<label for="check" class="checkbtn open"><i class="fa-solid fa-sm fa-bars"></i></label>
<label for="check" class="checkbtn close"><i class="fa-solid fa-sm fa-xmark"></i></label>
<ul>
    <li class="list home">
        <a href="coordinator.php">
            <span class="icon"><i class="fa-solid fa-sm fa-house"></i></span>
            <span class="text">HOME</span>
        </a>
    </li>
    <li class="list profile">
        <a href="coProfile.php">
            <span class="icon"><i class="fa-solid fa-sm fa-user"></i></span>
            <span class="text">PROFILE</span>
        </a>
    </li>
    <li class="list students">
        <a href="userList.php">
            <span class="icon"><i class="fa-solid fa-sm fa-users"></i></span>
            <span class="text">STUDENTS</span>
        </a>
    </li>
    <?php if($modeOfRegistration == 'ONSPOT'){ ?>
        <li class="list payment">
            <a href="paymentList.php">
                <span class="icon"><i class="fa-solid fa-sm fa-credit-card"></i></span>
                <span class="text" style="font-size: 12px;">PAYMENT LIST</span>
            </a>
        </li>
    <?php } ?>
    <li class="list absent">
        <a href="absent.php">
            <span class="icon"><i class="fa-solid fa-sm fa-user-check"></i></i></span>
            <span class="text" style="font-size: 12px;">ABSENTEES</span>
        </a>
    </li>
    <?php
    if ($_SESSION['EVE'] == 'ENTIRE EVENT' || $_SESSION['POSITION'] == 'FACULTY') {
    ?>
        <li class="list co">
            <a href="coList.php">
                <span class="icon"><i class="fa-solid fa-sm fa-users-gear"></i></span>
                <span class="text" style="font-size: 12px;">COORDINATOR</span>
            </a>
        </li>
    <?php } ?>
    <li class="list eventList">
        <a href="eventList.php">
            <span class="icon"><i class="fa-solid fa-sm fa-calendar-check"></i></span>
            <span class="text">EVENTS</span>
        </a>
    </li>
    <?php
    if ($_SESSION['EVE'] == 'ENTIRE EVENT' || $_SESSION['EVE'] == 'PAPER PRESENTATION') {
    ?>
        <li class="list download">
            <a href="downloadFileIF.php">
                <span class="icon"><i class="fa-solid fa-sm fa-download"></i></span>
                <span class="text">DOWNLOAD</span>
            </a>
        </li>
    <?php } ?>
    <li class="list prize">
        <a href="prizeSelect.php">
            <span class="icon"><i class="fa-solid fa-sm fa-award"></i></span>
            <span class="text">PRIZE</span></a>
    </li>
    <li class="list about">
        <a href="about.php">
            <span class="icon"><i class="fa-solid fa-sm fa-info"></i></span>
            <span class="text">ABOUT</span>
        </a>
    </li>
    <li class="list">
        <a href="../logout.php">
            <span class="icon"><i class="fa-solid fa-sm fa-sign-out"></i></span>
            <span class="text">LOGOUT</span>
        </a>
    </li>
    <div class="indicator"></div>
</ul>
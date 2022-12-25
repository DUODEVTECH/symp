<?php
include "config.php";

$sympDetails = mysqli_fetch_assoc(mysqli_query( $conn, "SELECT * FROM admin"));
$modeOfRegistration = mysqli_fetch_assoc(mysqli_query($conn, "SELECT DEFAULT(MODE) as MODE FROM users"))['MODE'];

$sympEmail   = $sympDetails['EMAIL'];
$sympName    = $sympDetails['SYMP_NAME'];
$sympYear    = $sympDetails['YEAR'];
$sympDate    = $sympDetails['DATE'];
$sympVision  = $sympDetails['VISION'];
$sympWa      = $sympDetails['WHATSAPP'];
$sympIn      = $sympDetails['INSTA'];
$sympFac1    = $sympDetails['FACULTY_1'];
$sympFac1Num = $sympDetails['FACULTY_1_NUM'];
$sympFac2    = $sympDetails['FACULTY_2'];
$sympFac2Num = $sympDetails['FACULTY_2_NUM'];
$sympStd1    = $sympDetails['STD_1'];
$sympStd1Num = $sympDetails['STD_1_NUM'];
$sympStd2    = $sympDetails['STD_2'];
$sympStd2Num = $sympDetails['STD_2_NUM'];
$sympAppPass = $sympDetails['APP_PASS'];
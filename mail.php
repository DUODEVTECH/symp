<?php
session_start();
include "config.php";
include "sympDetail.php";

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->Username = $sympEmail;
$mail->Password = $sympAppPass;
$mail->SMTPSecure = "ssl";
$mail->Port = 465;

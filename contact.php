<?php
session_start();
include "sympDetail.php";
include "mail.php";

if (isset($_POST['contact'])) {

    $name  = $_POST['name'];
    $email = $_POST['email'];
    $sub   = $_POST['sub'];
    $msg   = $_POST['msg'];

    $mail->setFrom($email, $name);
    $mail->addAddress($sympEmail);
    $mail->isHTML(true);

    $mail->Subject = $sub;
    $mail->Body = $msg;

    if ($mail->send())
        header("Location:index.php?msg=mailsent");
    else
        header("Location:index.php?msg=mailnotsent");
}

<?php
session_start();
include "config.php";
include "mail.php";
include "sympDetail.php";

function sendConfirmationMail($mail, $id, $name, $email) {
    global $sympEmail;
    global $sympName;
    global $sympYear;
    $mail->setFrom($sympEmail, $sympName);
    $mail->addAddress($email);

    $mail->Subject = "Confirmation Mail For ".$sympName." ".$sympYear;
    $mail->Body = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <style>
            h3{
                margin-left: 20px;
                margin-top: 30px;
                font-size: 20px;
                font-family: sans-serif;
            }
            p,li{
                color: rgb(0, 0, 0);
                letter-spacing: 2px;
                margin: 10px;
                font-size: 15px;
                font-family: sans-serif;
                padding: 1%;
            }
        </style>
        <title>Document</title>
    </head>
    <body>
        <h3>Dear '.$name.',</h3>
        <p>Congratulations! on your registration for <b style="font-size: 15px;">'.$sympName.' '.$sympYear.'</b> with us. It\'s our immense pleasure to
            have your presence in our National level Technical Symposium of CSE & AI&DS
            Department at <b style="font-size: 15px;">Erode Sengunthar Engineering College</b>, Perundurai on 20th October 2022.
            We also suggest you to go through the following guidelines for participating in the events as
            given below.</p>
        <p>
            Your '.$sympName.' ID is - '.$id.'
        </p>
    
        <p>Looking forward to your fullest co-operation and great participation throughout the even</p>
        <h3>'.$sympName.'-22 Basic Guidelines</h3>
        <ul>
            <li>Registrations are to be done in both online and on spot. Payment of Rs.200 for
                the registration will be collected on spot.</li>
            <li>The registered candidates must wear the issued participant identity card inside
                the college premises.</li>
            <li>Refreshments and certificates will be provided for all the participants.</li>
            <li>Participants are asked to send your ppts & abstracts for paper presentation or
                project presentation before October 16th, 2022 to <a href="mailto:'.$sympEmail.'">'.$sympEmail.'</a></li>
            <li>Participants can participate in any number of events without any restrictions.</li>
            <li>Participants are free to enjoy the event thoroughly along with maintaining the
                college rules and decorum.</li>
            <li>For every event the Jury\'s decision will be the fina</li>
        </ul>
        <h3>Venue</h3>
        <p> Main block,<br> Erode Sengunthar Engineering College,<br>Thudupathi, Perundurai, Erode-638057</p>

        <p>THANKS & BEST REGARDS <br> '.$sympName.'-22</p>
    </body>
    </html>';

    $mail->isHTML(true);
    $mail->addAttachment("Confirmation mail.pdf", "CONFIRMATION.pdf");
    if (!($mail->send())) {
        $mail->clearAddresses();
        if($_SESSION['privilage'] == "coordinator")
            header("Location: coordinator/userList.php?msg=notsend&id=" . $id);
        else
            header("Location: admin/userList.php?msg=sent");
    } else {
        $mail->clearAddresses();
        return 1;
    }
}

if(isset($_POST['send_mail']) && $_POST['send']){
$ids = $_POST['ids'];
foreach($ids as $id){
    $users = mysqli_query($conn, "SELECT ID, NAME, EMAIL, VERIFY FROM users WHERE VERIFY=1 AND ID='$id'");

    if (mysqli_num_rows($users) > 0) {
        while ($user = mysqli_fetch_assoc($users)) {
            sendConfirmationMail($mail, $user['ID'], $user['NAME'], $user['EMAIL']);
        }
    }
}
    header("Location: admin/userList.php?msg=sent");
} else {
    header("Location: admin/userList.php");
}
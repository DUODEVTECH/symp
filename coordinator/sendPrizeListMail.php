<?php
session_start();
include "../config.php";
include "../mail.php";
include "../sympDetail.php";

function sendPrizeMail($mail, $id, $name, $email, $event, $place)
{
    global $sympEmail;
    global $sympName;
    global $sympYear;
    $mail->setFrom( $sympEmail, $sympName." ".$sympYear);
    $mail->addAddress($email);

    $mail->Subject = $event . " Prize Winner";
    $mail->Body = "<h1 style=\"text-align:center; font-family:monospace;\">Congratulations</h1><br>";

    $mail->isHTML(true);
    if (!($mail->send()))
        header("Location:prizeSelect.php?msg=notSend&id=$id");
    else
        return 1;
};

$first  = "SELECT users.ID,users.NAME,users.EMAIL,event.EVENTS,event.FIRST FROM users INNER JOIN event ON event.FIRST=users.ID";
$second = "SELECT users.ID,users.NAME,users.EMAIL,event.EVENTS,event.SECOND FROM users INNER JOIN event ON event.SECOND=users.ID";
$third  = "SELECT users.ID,users.NAME,users.EMAIL,event.EVENTS,event.THIRD FROM users INNER JOIN event ON event.THIRD=users.ID";

$FirstList  = mysqli_query($conn, $first);
$secondList = mysqli_query($conn, $second);
$ThirdList  = mysqli_query($conn, $third);

if (mysqli_num_rows($FirstList) > 0) {
    while ($winner = mysqli_fetch_assoc($FirstList)) {
        sendPrizeMail($mail, $winner['ID'], $winner['NAME'], $winner['EMAIL'], $winner['EVENTS'], "First");
    }
}
if (mysqli_num_rows($secondList) > 0) {
    while ($winner = mysqli_fetch_assoc($secondList)) {
        sendPrizeMail($mail, $winner['ID'], $winner['NAME'], $winner['EMAIL'], $winner['EVENTS'], "Second");
    }
}
if (mysqli_num_rows($ThirdList) > 0) {
    while ($winner = mysqli_fetch_assoc($ThirdList)) {
        sendPrizeMail($mail, $winner['ID'], $winner['NAME'], $winner['EMAIL'], $winner['EVENTS'], "Third");
    }
}

header("Location:prizeSelect.php?msg=send");

<?php
session_start();
include "../config.php";
include "../mail.php";
include "../sympDetail.php";

function sendSelectMail($mail, $id, $name, $email)
{
    global $sympName;
    global $sympEmail;
    global $sympYear;
    global $sympStd1Num;

    $mail->setFrom( $sympEmail, $sympName.' '.$sympYear);
    $mail->addAddress($email);

    $mail->Subject = "Selected for Paper Presentation";
    $mail->Body = '<!DOCTYPE html>
    <html lang="en">
        <body class="admin-panel">
            <style>
                @import url("https://fonts.googleapis.com/css2?family=Alkalami&family=Poppins&display=swap");
                *{
                    font-family: "Poppins", sans-serif;
                }
                a{
                    text-decoration: none;
                    color: black;
                }
                div{
                    margin: 20px;
                }
            </style>
            <div>
                <h1 style="padding: 2%; text-align: center;">
                    CONGRATULATIONS! <br>
                    WELCOME TO '.$sympName.' '.$sympYear.'!
                </h1>
                <div>
                    <ul style="text-align: center">
                        <li style="display: inline-block;margin: 0 10px;">
                            <a href="https://erode-sengunthar.ac.in/innowiz2k22/">WEBSITE</a>
                        </li>
                        <li style="display: inline-block;margin: 0 10px;">
                            <a href="mailto:'.$sympEmail.'>REACH US</a>
                        </li>
                        <li style="display: inline-block;margin: 0 10px;">
                            <a href="tel:+91'.$sympStd1Num.'">CALL US</a>
                        </li>
                    </ul>
                </div=>
    
                <div>
                    <p style="text-align: justify;">Greetings from the <span style=" font-size: 15px">Erode Sengunthar Engineering College</span> Paper presentation Team! Congratulations!<span style="font-size: 15px">Your Paper is Short Listed.</span></p>
                    <p style="text-align: justify;">You Have Been Selected For The Paper Presentation Event In The <span style="font-size: 15px">'.$sympName.' '.$sympYear.'!</span>, Only Team Leaders Need To Fill This Form.</p>
                </div>
                
                <center>
                    <button style="border: none; outline: none; border-radius: 25px; padding: 12px 15px; background: rgb( 8, 205, 8);"><a href="https://forms.gle/yB2cXriPYEffQDJb6" style="color:black;">Click here to open Form</a></button>
                </center>
                <br>
            </div>
            <hr style="border: 1px white solid" /><br>
            <div style="display: inline-block">
                <div>
                    <h3>Rules :</h3>
                    <ul style="text-align: start;">
                        <li>A team may consist of 1 to 3 members max.</li>
                        <li>The PPT for your paper presentation could have the maximum of 15 slides.</li>
                        <li>The maximum time limit for each presentation is 5 minutes.</li>
                        <li>Don’t get your ppt in Pen drive, only mail is allowed.</li>
                    </ul>
                </div>
    
                <br>
                <h3>Student Co-ordinators :</h3>
                <p>
                    Kishore Kumar S (IV/CSE) <br>Kowsik K (IV/CSE)<br>Preethasri U (IV/CSE)<br>Sivanithi V (IV/CSE)
                </p>
    
                <h3>Event Details :</h3>
                <p>
                    When: 20 th October 2022 <br>
                    Where: Main Block,Erode Sengunthar Engineering College,Thudupathi <br>
                    Wish you all the best. <br><br>
                    <b>Regards, <br>
                    PPT Event Team,<br>
                    Department of CSE and AI&DS, <br>
                    Erode Sengunthar Engineering College, <br>
                    Thudupathi, ERODE-638 057.<b>
                </p>
            </div>
    
            <div>
                <p style="color: white">
                    ERODE SENGUNTHAR ENGINEERING COLLEGE <br>
                    THUDUPATHI, PERUNDURAI,<br>
                    ERODE 638 057 .
                </p>
            </div>
        </body>
    </html>
    ';
    $mail->isHTML(true);
    $mail->addAttachment("../PPT Confirmation.pdf", "PPT CONFIRMATION.pdf");

    if (!($mail->send())) {
        $mail->clearAddresses();
        header("Location: downloadFileIF.php?msg=notsend&id=" . $id);
    } else
        return 1;
}

if (isset($_POST['submit']) && $_POST['submit'] == "single") {

    $id = $_POST['id'];
    $topic = $_POST['topic'];

    $file_result = mysqli_query($conn, "SELECT * FROM ppt_files WHERE SYMPID='$id' AND TOPIC='$topic'");

    if (mysqli_num_rows($file_result) === 1) {

        $row = mysqli_fetch_assoc($file_result);
        $file = $row['PATH'] . basename($row['FILENAME']);

        if (!empty($file) && file_exists($file)) {

            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $file_name = $id . "." . $ext;

            header("Content-Description: File Transfer");
            header("Content-Type: application/octet-stream");
            header("Cache-Control: public");
            header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');
            header("Content-Size: " . filesize($file));
            header("Content-Transfer-Encoding: binary");

            readfile($file);
        }
    }
} else if (isset($_POST['submit']) && $_POST['submit'] == "all") {

    $id = array();

    $ids = mysqli_query($conn, "SELECT SYMPID,FILENAME FROM ppt_files");
    if (mysqli_num_rows($ids) > 0) {
        while ($row = mysqli_fetch_assoc($ids)) {
            $id[$row['SYMPID']] = $row['FILENAME'];
        }

        $zip = new ZipArchive;
        $zipname = "PPT - " . time() . ".zip";

        if ($zip->open($zipname, ZipArchive::CREATE) !== true) {
            header("Location: downloadFileIF.php?msg='cantDN'");
        }

        foreach ($id as $key => $file) {
            $ext = pathinfo("../ppt/" . $file, PATHINFO_EXTENSION);

            $zip->addFile("../ppt/" . $file, $key . "." . $ext);
        }

        $zip->close();

        if (file_exists($zipname)) {

            header("Content-type: application/zip");
            header('Content-Disposition: attachment; filename="' . $zipname . '";');

            readfile($zipname);

            unlink($zipname);
        }
    } else {
        header("Location: downloadFileIF.php?msg=nouser");
    }
} else if (isset($_POST['submit']) && $_POST['submit'] == "selectALL") {

    mysqli_query($conn, "UPDATE ppt_files SET RESULT='SELECTED'");
    echo "<span id='sucMsg'>All students are selected for Paper Presentation</span>";
} else if (isset($_POST['submit']) && $_POST['submit'] == "selectChecked") {

    $ids = $_POST['ids'];

    foreach ($ids as $id)
        mysqli_query($conn, "UPDATE ppt_files SET RESULT='SELECTED' WHERE SYMPID='$id'");

    echo "<span id='sucMsg'>Selected successfully</span>";
} else if (isset($_POST['submit']) && $_POST['submit'] == "reject") {
    $id = $_POST['id'];
    mysqli_query($conn, "UPDATE ppt_files SET RESULT='REJECTED' WHERE SYMPID='$id'");
    header("Location: downloadFileIF.php?msg=RO");
} else if (isset($_POST['submit']) && $_POST['submit'] == 'send') {

    $emailID = mysqli_query($conn, "SELECT * FROM users INNER JOIN ppt_files ON users.ID=ppt_files.SYMPID");
    if (mysqli_num_rows($emailID) > 0) {
        while ($email = mysqli_fetch_assoc($emailID)) {
            sendSelectMail($mail, $email['SYMPID'], $email['NAME'], $email['EMAIL']);
        }
        header("Location: downloadFileIF.php?msg=sent");
    } else {
        header("Location: downloadFileIF.php?msg=nouser");
    }
}

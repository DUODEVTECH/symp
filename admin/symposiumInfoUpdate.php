<?php
session_start();
include "../config.php";
include "../autologout.php";
include "../sympDetail.php";

if(isset($_POST['save-btn'])){
    // Change Password and Email id of Admin
    if($_POST['save-btn'] == "pass"){
        $email = $_POST['email'];
        $pass = $_POST['new_pass'];
        // Updating values
        mysqli_query($conn, "UPDATE admin SET EMAIL='$email', PASS='$pass' WHERE NAME='admin'");
        // Redirecting back to symposium info
        header("Location: symposiumInfo.php?msg=pw");
    } 
    // Symposium name and date year update
    else if($_POST['save-btn'] == "name"){
        $name = $_POST['symp_name'];
        $date = $_POST['date'];
        // Extracting year from date given
        $year ='2K'.substr(str_replace('T', ' ', $date), 2, 4);

        // Updating values
        mysqli_query($conn, "UPDATE admin SET SYMP_NAME='$name', DATE='$date', YEAR='$year' WHERE NAME='admin'");
        // Redirecting back to symposium info
        header("Location: symposiumInfo.php?msg=nmc");
    }
    // Social Media Links update
    else if($_POST['save-btn'] == "link"){
        $wa = $_POST['wa_link'];
        $in = $_POST['in_link'];

        // Updating values
        mysqli_query($conn, "UPDATE admin SET WHATSAPP='$wa', INSTA='$in' WHERE NAME='admin'");
        // Redirecting back to symposium info
        header("Location: symposiumInfo.php?msg=link");
    }
    // Footer Co ordinator update
    else if($_POST['save-btn'] == "co"){
        $fac_1 = $_POST['fac-co-1'];
        $fac_1_num = $_POST['fac-co-1-num'];
        $fac_2 = $_POST['fac-co-2'];
        $fac_2_num = $_POST['fac-co-2-num'];
        $std_1 = $_POST['std-1'];
        $std_1_num = $_POST['std-1-num'];
        $std_2 = $_POST['std-2'];
        $std_2_num = $_POST['std-2-num'];

        // Updating values
        mysqli_query($conn, "UPDATE admin SET FACULTY_1='$fac_1', FACULTY_1_NUM='$fac_1_num', FACULTY_2='$fac_2', FACULTY_2_NUM='$fac_2_num', STD_1='$std_1', STD_1_NUM='$std_1_num', STD_2='$std_2', STD_2_NUM='$std_2_num' WHERE NAME='admin'");
        // Redirecting to symposium info page
        header("Location: symposiumInfo.php?msg=fco");
    }
    // PHPMailer Password update
    else if($_POST['save-btn'] == "app"){
        $app_pass = $_POST['app_pass'];

        // Update Values
        mysqli_query($conn, "UPDATE admin SET APP_PASS='$app_pass' WHERE NAME='admin'");
        // Redirecting to symposium info page
        header("Location: symposiumInfo.php?msg=ap");
    }
    // Logo and Poster update
    else if($_POST['save-btn'] == "img"){
        // Getting files
        $uploadedTitleImage  = $_FILES['title-logo'];
        $uploadedAboutImage  = $_FILES['abt-img'];
        $uploadedFooterImage = $_FILES['f-img'];
        $uploadedPosterImage = $_FILES['poster'];
        
        // Change Name
        $uploadTitleImage  = "../img/logo/title_logo.".pathinfo($uploadedTitleImage['name'])['extention'];
        $uploadAboutImage  = "../img/logo/about_img.".pathinfo($uploadedAboutImage['name'])['extention'];
        $uploadFooterImage = "../img/logo/footer_img.".pathinfo($uploadedFooterImage['name'])['extention'];
        $uploadPosterImage = "../img/logo/poster.".pathinfo($uploadedPosterImage['name'])['extention'];

        // Deleting files
        if(file_exists($uploadTitleImage))
            unlink($uploadTitleImage);
        if(file_exists($uploadAboutImage))
            unlink($uploadAboutImage);
        if(file_exists($uploadFooterImage))
            unlink($uploadFooterImage);
        if(file_exists($uploadPosterImage))
            unlink($uploadPosterImage);

        // Moving upload images
        move_uploaded_file( $uploadedTitleImage['tmp_name'], $uploadTitleImage);
        move_uploaded_file( $uploadedAboutImage['tmp_name'], $uploadAboutImage);
        move_uploaded_file( $uploadedFooterImage['tmp_name'], $uploadFooterImage);
        move_uploaded_file( $uploadedPosterImage['tmp_name'], $uploadPosterImage);

        header("Location: symposiumInfo.php?msg=img");
    }
    // Symposium vision in about update
    else if($_POST['save-btn'] == "about"){
        $vision = $_POST['symp-vision'];

        // Updateing in database
        mysqli_query( $conn, "UPDATE admin SET VISION='$vision'");

        // Redirect to previous page
        if($_POST['page'] == "1"){
            header("Location: aboutEdit.php?msg=abt");
        }
        else{
            header("Location: symposiumInfo.php?msg=abt");
        }
    }
}
else{
    header("Location: symposiumInfo.php");
}
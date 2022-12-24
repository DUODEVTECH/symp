<?php
session_start();
include "../config.php";

function validate($data)
{
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function check($conn, $id)
{
    $check = mysqli_query($conn, "SELECT ID FROM users WHERE ID='$id'");
    if (mysqli_num_rows($check) == 1)
        return $id;
    else
        return 0;
}
    
if (isset($_POST['submit'])) {
    if(isset($_POST['event'])){
        $id = check($conn, validate($_POST['id']));
        if($id == "0"){
            header("Location: absent.php?msg=nouser");
        }
        $notRegEvents = array();
        $evt = 0;
        
        if ($id == '') {
            header("Location: absent.php?msg=emp");
        }
        
        foreach ($_POST['event'] as $event) {
            $event = mysqli_fetch_assoc(mysqli_query( $conn, "SELECT EVENT_ID,EVENTS FROM event WHERE EVENT_ID='$event'"))['EVENTS'];

            $check = mysqli_query($conn, "SELECT EVENT,SYMPID FROM user_reg_event WHERE SYMPID='{$id}' AND EVENT='{$event}'");
            
            if (mysqli_num_rows($check) > 0) {
                $sql = "UPDATE user_reg_event SET ATTENDANCE='ABSENT' WHERE SYMPID='$id' AND EVENT='{$event}'";
                mysqli_query($conn, $sql);
            } else {
                array_push($notRegEvents, $event);
                $evt = 1;
            }
        }
        if ($evt == 1) {
            $notRegEvents = http_build_query($notRegEvents);
            header("Location:absent.php?msg=notReg&id=$id&" . $notRegEvents);
        } else {
            header("Location:absent.php?msg=done");
        }
    } else {
        header("Location: absent.php?msg=nocheck");
    }
} if (isset($_POST['present'])) {
    $id = $_POST['id'];
    $evt = $_POST['event'];
    mysqli_query($conn, "UPDATE user_reg_event SET ATTENDANCE='PRESENT' WHERE SYMPID='$id' AND EVENT='$evt'");
    header("Location:absent.php?msg=present");
}

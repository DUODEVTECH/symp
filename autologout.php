<?php
if(time() - $_SESSION['last_sign'] < 0){
    header("Location: ../logout.php");
}
$_SESSION['last_sign'] = time();
?>
<?php
// Databse connection file
$host = "localhost";
$user = "root";
$pass = "";
$db   = "erodesen_symposium";
$conn = mysqli_connect($host, $user, $pass, $db);

// if connection got fail error message wil be printed
if (!$conn) {
    echo "Connection Failed!";
}

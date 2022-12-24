<?php
session_start();
include "config.php";
include "sympDetail.php";

// Fetching PPT File Details
$res = mysqli_query( $conn, "SELECT * FROM ppt_files");

$html = "S.NO,SYMP ID, NAME, DEPARTMENT, COLLEGE, TOPIC, ABSTRACT\n\n";
$fileName = "Paper PResentation Abstract - ".date("Y-m-d").".csv";
if(mysqli_num_rows($res) > 0){
    $i = 1;
    while($row = mysqli_fetch_assoc($res)){
        // Fetching Team Leader and Team mate details
        $tlDetail = mysqli_fetch_assoc(mysqli_query( $conn, "SELECT * FROM users WHERE ID='{$row['TL']}'"));
        $tm2Detail = mysqli_fetch_assoc(mysqli_query( $conn, "SELECT * FROM users WHERE ID='{$row['TEAM_2']}'"));
        $tm3Detail = mysqli_fetch_assoc(mysqli_query( $conn, "SELECT * FROM users WHERE ID='{$row['TEAM_3']}'"));

        $html .= $i.','.$row['TL'].','.$tlDetail['NAME'].','.$tlDetail['DEPARTMENT'].','.$tlDetail['COLLEGE'].','.$row['TOPIC'].','.$row['ABSTRACT']."\n".','.$tm2Detail['ID'].','.$tm2Detail['NAME'].','.$tm2Detail['DEPARTMENT'].",,,\n".','.$tm3Detail['ID'].','.$tm3Detail['NAME'].','.$tm3Detail['DEPARTMENT'].",,,\n\n";
        $i++;
    }

    header("Content-type: text/csv");
    header('Content-Disposition: attachment; filename="'.$fileName.'";');
    
    echo $html;

} else {
    $html .= "No files found.";

    header("Content-type: text/csv");
    header('Content-Disposition: attachment; filename="'.$fileName.'";');
    
    echo $html;
}
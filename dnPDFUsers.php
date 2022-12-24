<?php
session_start();
include "config.php";

$eve = $_SESSION['EVE'];
if ($eve != "ENTIRE EVENT" && $eve != "admin") {
    $res = mysqli_query($conn, "SELECT * FROM users INNER JOIN user_reg_event ON users.ID=user_reg_event.SYMPID WHERE user_reg_event.EVENT='$eve' ORDER BY users.ID");
} else {
    $res = mysqli_query($conn, "SELECT * FROM users ORDER BY ID");
}
if (mysqli_num_rows($res) > 0) {
    $filename = "Registered-Student-List-" . date("Y-m-d") . ".pdf";
    require('FPDF/fpdf.php');

    $pdf = new FPDF('L', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', '11');
    $pdf->Cell(25, 10, 'ID', 1, 0, 'C');
    $pdf->Cell(55, 10, 'NAME', 1, 0);
    $pdf->Cell(27, 10, 'PHONE', 1, 0, 'C');
    $pdf->Cell(20, 10, 'YEAR', 1, 0, 'C');
    $pdf->Cell(80, 10, 'DEPARTMENT', 1, 0, 'C');
    $pdf->Cell(45, 10, 'ROLL NO', 1, 1, 'C');


    while ($row = mysqli_fetch_assoc($res)) {
        $pdf->Cell(25, 10, $row['ID'], 1, 0, 'C');
        $pdf->Cell(55, 10, $row['NAME'], 1, 0);
        $pdf->Cell(27, 10, $row['PHONE'], 1, 0, 'C');
        $pdf->Cell(20, 10, $row['YEAR'], 1, 0, 'C');
        $pdf->Cell(80, 10, $row['DEPARTMENT'], 1, 0);
        $pdf->Cell(45, 10, $row['CLG_ROLL'], 1, 1);
    }
    $pdf->Output('D', $filename);
    ob_end_flush();
} else {
    header("Location:userList.php?msg=noRow");
}

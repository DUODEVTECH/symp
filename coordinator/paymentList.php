<?php
session_start();
include "../config.php";
include "../autologout.php";
include "../sympDetail.php";

if (isset($_SESSION['EMAIL']) && isset($_SESSION['NAME']) && isset($_SESSION['privilage']) && $_SESSION['privilage'] == "coordinator") {
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="../img/logo/title_logo.png">
		<title>User List - Co Ordinator</title>
		<link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="https://kit.fontawesome.com/d66f5928de.js" crossorigin="anonymous"></script>
	</head>

	<body>
		<div class="navigation"></div>

		<div class="logo-img" style="margin-top: 90px;">
			<img src="../img/logo/logo.png" alt="College logo">
			<img src="../img/logo/naac.png" alt="NAAC logo">
		</div>

		<h1 style="margin-top: 80px;"><a href="https://erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
				<h3>(An Autonomous Institution)</h3>
			</a></h1><br>
		<h2 class="logo"><?php echo $sympName.' <span>'.$sympYear; ?></span></h2><br>
		<h3>PAID STUDENT LIST</h3>

        <div id="search">
            <div class="input-group">
                <label for="input">SEARCH STUDENT :</label>
                <input type="text" id="input" onkeyup="filterBySearch()" placeholder="Enter sympid to search">
            </div>
        </div>

        <div style="overflow: auto;">
            <table>
                <tr>
                    <th>S.NO</th>
                    <th>SYMP ID</th>
                    <th>NAME</th>
                    <th>COLLEGE</th>
                </tr>
                <?php
                $i = 1;
                $sql = $_SESSION['EVE'] == 'ENTIRE EVENT' ? "SELECT * FROM users WHERE PAYMENT='PAID'" : "SELECT * FROM users INNER JOIN user_reg_event as evtReg ON users.ID=evtReg.SYMPID WHERE evtReg.EVENT = '$eve' AND users.PAYMENT='PAID'";
                $user = mysqli_query($conn, $sql);
                
                if(mysqli_num_rows($user) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<tr>";
                        echo "<td>$i</td>";
                        echo "<td>".$row['ID']."</td>";
                        echo "<td>".$row['NAME']."</td>";
                        echo "<td>".$row['COLLEGE']."</td>";
                        $i++;
                    }
                } else{
                    echo "<tr><td colspan='5'>No students paid</td></tr>";
                }
                ?>
            </table><br><br>
        </div>


        <script>

            function filterBySearch() {

            var filterBy, input, filter, table, tr, td, i, txtValue;

            input = document.getElementById("input");
            filter = input.value.toUpperCase();
            tr = document.getElementsByTagName("tr");

            if (filter == "") {
                tr.style.display = "";
            } else {
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[1];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
            }

            $(document).ready(function () {
                $(".navigation").load("navbarCO.php");
                window.setTimeout(function () {
                    $(".navigation .list.payment").addClass("active");
                }, 700);
            });
        </script>

</body>

</html>

<?php
} else {
session_unset();
session_destroy();
header("Location:../index.php?msg=ReLogin");
exit();
}

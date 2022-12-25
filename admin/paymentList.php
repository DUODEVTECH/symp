<?php
session_start();
include "../config.php";
include "../autologout.php";
include "../sympDetail.php";

if (isset($_SESSION['EMAIL']) && isset($_SESSION['NAME']) && isset($_SESSION['privilage']) && $_SESSION['privilage'] == "admin") {
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="../img/logo/title_logo.png">
		<title>Paid Students List - Admin</title>
		<link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="https://kit.fontawesome.com/d66f5928de.js" crossorigin="anonymous"></script>
	</head>

	<body class="admin-panel">

		<div class="navigation-admin"></div>
		<div class="wrapper">
			<div class="logo-img" style="margin-top: 90px;">
				<img src="../img/logo/logo.png" alt="College logo">
				<img src="../img/logo/naac.png" alt="NAAC logo">
			</div>

			<h1 style="margin-top: 80px;"><a href="https://erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
					<h3>(An Autonomous Institution)</h3>
				</a></h1><br>
			<h2 class="logo"><?php echo $sympName.' <span>'.$sympYear; ?></span></h2><br>
			<h3>PAID STUDENTS LIST</h3><br>

            <?php
                if(isset($_GET['msg']) && $_GET['msg'] == "notpay"){
                    echo "<span id='sucMsg'>Student status changed to not paid</span>";
                }
                if(isset($_GET['msg']) && $_GET['msg'] == "paid"){
                    echo "<span id='sucMsg'>Student status changed to paid</span>";
                }
            ?>

            <form action="onspotRegistration.php" method="post" class="form">
                <h3>ADD STUDENT</h3><br>    
                <input type="text" name="id" placeholder="Enter symp id" required><br>
                <button type="submit" name="paid-btn">PAID</button>
            </form>

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
                        <th>NOT PAID</th>
                    </tr>
                    <?php
                    $i = 1;
                    $result = mysqli_query($conn, "SELECT * FROM users WHERE PAYMENT='PAID'");
                    
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>".$row['ID']."</td>";
                            echo "<td>".$row['NAME']."</td>";
                            echo "<td>".$row['COLLEGE']."</td>";
                            echo "<td><a href='onspotRegistration.php?sympid=".$row['ID']."'><button><i class='fa-solid fa-ban'></i></button></a></td>";
                            $i++;
                        }
                    } else{
                        echo "<tr><td colspan='5'>No students paid</td></tr>";
                    }
                    ?>
                </table><br><br>
            </div>

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


            $(document).ready(function() {
                $('.navigation-admin').load('navbaradmin.php');
                window.setTimeout(function(){
                    $('.navigation-admin .list.payment').addClass('active');
                }, 700);
            });
        </script>
    </body>
    </html>
<?php
} else {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
}
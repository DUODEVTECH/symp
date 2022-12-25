<?php
session_start();
include "../config.php";
include "../autologout.php";
include "../sympDetail.php";

$email = $_SESSION['EMAIL'];
$res = mysqli_query($conn, "SELECT * FROM users WHERE EMAIL='$email'");
$row = mysqli_fetch_assoc($res);

mysqli_data_seek($res, 0);

if (isset($_SESSION['EMAIL']) && isset($_SESSION['NAME']) && isset($_SESSION['privilage']) && $_SESSION['privilage'] == "user") {
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="../img/logo/title_logo.png">
		<title>Profile - User</title>
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
		<h2 class="logo"><?php echo $sympName; ?> <span><?php echo $sympYear; ?></span></h2><br>

		<h3>Profile</h3>

		<?php
		if (isset($_GET["msg"]) && $_GET["msg"] == "done") {
			echo "<span id='sucMsg'>Profile updated successfully.</span><br>";
		}
		?>
		<div class="edit"><button onclick="tableToForm(this)">EDIT</button></div>

		<form action="updateUser.php" method="post" id="editUser" method="post" class="form">
			<table class="user">
				<tr>
					<td>SYMPOSIUM ID</td>
					<td class="userTD"><?php echo $row['ID']; ?></td>
				</tr>
				<tr>
					<td>NAME</td>
					<td class="userTD"><?php echo $row['NAME']; ?></td>
				</tr>
				<tr>
					<td>COLLEGE ROLL</td>
					<td class="userTD"><?php echo $row['CLG_ROLL']; ?></td>
				</tr>
				<tr>
					<td>EMAIL</td>
					<td class="userTD"><?php echo $row['EMAIL']; ?></td>
				</tr>
				<tr>
					<td>MOBILE NUMBER</td>
					<td class="userTD"><?php echo $row['PHONE']; ?></td>
				</tr>
				<tr>
					<td>YEAR</td>
					<td class="userTD"><?php echo $row['YEAR']; ?></td>
				</tr>
				<tr>
					<td>DEGREE</td>
					<td class="userTD"><?php echo $row['DEGREE']; ?></td>
				</tr>
				<tr>
					<td>DEPARTMENT</td>
					<td class="userTD"><?php echo $row['DEPARTMENT']; ?></td>
				</tr>
				<tr>
					<td>COLLEGE</td>
					<td class="userTD"><?php echo $row['COLLEGE']; ?></td>
				</tr>
				
			</table><br><br>

			<button type="submit" id="submitBtn" style="display: none;">SAVE</button><br><br><br><br>
		</form>

		<script>
			function tableToForm(a) {
				const year_val = ["I", "II", "III", "IV", "V"];
				const degree_val = ["BE", "BTECH", "ME", "MTECH"];
				const field = ["name", "clg_roll", "email", "mobile", "", "dep", "clg"];

				for (i = 1, j = 0; i < document.querySelectorAll(".userTD").length; i++, j++) {

					if (i == 5) {
						select = document.createElement("select");
						select.name = "year";
						for (j = 0; j < 5; j++) {
							option = document.createElement("option");
							option.value = year_val[j];
							option.text = year_val[j];
							select.add(option);
							select.value = document.querySelectorAll(".userTD")[i].innerHTML.trim();
						}
						document.querySelectorAll(".userTD")[i].innerHTML = "";
						document.querySelectorAll(".userTD")[i].appendChild(select);
					} else if (i == 6) {

						select = document.createElement("select");
						select.name = "deg";
						for (j = 0; j < 4; j++) {
							option = document.createElement("option");
							option.value = degree_val[j];
							option.text = degree_val[j];
							select.add(option);
							select.value = document.querySelectorAll(".userTD")[i].innerHTML.trim();
						}
						document.querySelectorAll(".userTD")[i].innerHTML = "";
						document.querySelectorAll(".userTD")[i].appendChild(select);
					} else {
						var input = document.createElement("input");
						input.value = document.querySelectorAll(".userTD")[i].innerHTML.trim();
						input.name = field[j];

						document.querySelectorAll(".userTD")[i].innerHTML = '';
						document.querySelectorAll(".userTD")[i].appendChild(input);
					}
				}

				a.disabled = true;
				document.getElementById("submitBtn").style.display = "inline-block";
			}

			$(document).ready(function() {
				$(".navigation").load("navbarUser.php");
				window.setTimeout(function() {
					$(".navigation > ul > li.profile").addClass("active");
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

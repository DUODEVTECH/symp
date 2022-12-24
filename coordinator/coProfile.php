<?php
session_start();
include "../config.php";
include "../autologout.php";
include "../sympDetail.php";

$roll = $_SESSION['ID'];
$sql = "SELECT * FROM coordinator WHERE ROLLNO='$roll'";

$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));

if (isset($_SESSION['EMAIL']) && isset($_SESSION['NAME']) && isset($_SESSION['privilage']) && $_SESSION['privilage'] == "coordinator") {
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="../img/logo/title_logo.png">
		<title>Profile - Co Ordinator</title>
		<link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="https://kit.fontawesome.com/d66f5928de.js" crossorigin="anonymous"></script>
	</head>

	<body>
		<div class="navigation"></div>

		<?php
		if (isset($_GET["msg"]) && $_GET["msg"] == "done") {
			echo "<span id='sucMsg'>Profile updated successfully.</span><br>";
		}
		?>

		<div class="logo-img" style="margin-top: 90px;">
			<img src="../img/logo/logo.png" alt="College logo">
			<img src="../img/logo/naac.png" alt="NAAC logo">
		</div>

		<h1 style="margin-top: 80px;"><a href="https://www.erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
				<h3>(An Autonomous Institution)</h3>
			</a></h1>
		<h2 class="logo"><?php echo $sympName.' <span>'.$sympYear; ?></span></h2>

		<h3>PROFILE</h3>

		<div class="edit"><button onclick="tableToForm(this)">EDIT</button></div>

		<form action="updateCO.php" method="post" id="editUser" method="post" class="form">
			<table class="user">
				<tr>
					<td>ROLL NUMBER</td>
					<td class="userTD"><?php
										echo $row['ROLLNO'];
										?></td>
				</tr>
				<tr>
					<td>NAME</td>
					<td class="userTD"><?php
										echo $row['NAME'];
										?></td>
				</tr>
				<tr>
					<td>EMAIL</td>
					<td class="userTD"><?php
										echo $row['EMAIL'];
										?></td>
				</tr>
				<tr>
					<td>MOBILE NUMBER</td>
					<td class="userTD"><?php
										echo $row['PHONE'];
										?></td>
				</tr>
				<tr>
					<td>DEPARTMENT</td>
					<td class="userTD"><?php
										echo $row['DEPARTMENT'];
										?></td>
				</tr>
				<tr>
					<td>EVENT</td>
					<td class="userTD">
						<?php
						echo $row['EVENT'];
						?>
					</td>
				</tr>
			</table><br><br>

			<button type="submit" id="submitBtn" style="display: none;">SAVE</button><br><br><br><br>
		</form>

		<script>
			function tableToForm(a) {
				const field = ["roll", "name", "email", "mobile", "dep", "eve"];

				for (i = 0, j = 0; i < document.querySelectorAll(".userTD").length; i++, j++) {

					var input = document.createElement("input");
					input.value = document.querySelectorAll(".userTD")[i].innerHTML.trim();
					input.name = field[j];

					document.querySelectorAll(".userTD")[i].innerHTML = '';
					document.querySelectorAll(".userTD")[i].appendChild(input);
				}

				a.disabled = true;
				document.getElementById("submitBtn").style.display = "inline-block";
			}

			$(document).ready(function() {
				$(".navigation").load("navbarCO.php");
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

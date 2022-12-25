<?php
session_start();
include "../config.php";
include "../autologout.php";
include "../sympDetail.php";

$eve = $_SESSION['EVE'];

$users    = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
$college  = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT COLLEGE FROM users"));

if (isset($_SESSION['EMAIL']) && isset($_SESSION['NAME']) && isset($_SESSION['privilage']) && $_SESSION['privilage'] == "coordinator") {
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="../img/logo/title_logo.png">
		<title>Home - Co Ordinator</title>
		<link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="https://kit.fontawesome.com/d66f5928de.js" crossorigin="anonymous"></script>
	</head>

	<body>
		<div class="navigation"></div>


		<?php
		if ($_SESSION['log'] == 1) {
			echo "<span id='logMsg'>LOGGED IN SUCCESSFULLY</span>";
			$_SESSION['log']++;
		}
		?>

		<div class="logo-img" style="margin-top: 90px;">
			<img src="../img/logo/logo.png" alt="College logo">
			<img src="../img/logo/naac.png" alt="NAAC logo">
		</div>

		<h1 style="margin-top: 80px;"><a href="https://erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
				<h3>(An Autonomous Institution)</h3>
			</a></h1><br>
		<h2 class="logo"><?php echo $sympName.' <span>'.$sympYear; ?></span></h2><br>
		<h3>STATISTICS</h3>
		<br><br>
		
		<div class="container">
			<div class="card">
				<p class="count"><?php echo $users; ?></p>
				<span class="type">Students</span>
			</div>
			<div class="card">
				<p class="count"><?php echo $college; ?></p>
				<span class="type">Colleges</span>
			</div>
		</div>
		<h3>Event Registration Count:</h3>
		<div class="container">
			<?php
			$events = mysqli_query($conn, "SELECT EVENTS, STATUS FROM event WHERE EVENTS!='$sympName' AND STATUS='OPEN'");
			if (mysqli_num_rows($events) > 0) {
				while ($eve = mysqli_fetch_assoc($events)) {
					$count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user_reg_event WHERE EVENT='{$eve['EVENTS']}'"));
					echo "<div class='card'><p class='count'>{$count}</p><span class='event-name'>{$eve['EVENTS']}</span></div>";
				}
			}
			?>
		</div><br><br>
		<script>
			$(document).ready(function() {
				$(".navigation").load("navbarCO.php");
				window.setTimeout(function() {
					$(".navigation > ul > li.home").addClass("active");
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

<?php
session_start();
include "../config.php";
include "../autologout.php";
include "../sympDetail.php";

$id = $_SESSION['ID'];

$tech = mysqli_query($conn, "SELECT * FROM event WHERE TYPE='TECHNICAL' AND STATUS='OPEN'");
$nontech    = mysqli_query($conn, "SELECT * FROM event WHERE TYPE='NON_TECHNICAL' AND STATUS='OPEN'");
$co       = mysqli_query($conn, "SELECT NAME, PHONE, EVENT FROM coordinator");
$workRows = mysqli_num_rows($tech);
$eveRows  = mysqli_num_rows($nontech);


if (isset($_SESSION['EMAIL']) && isset($_SESSION['NAME']) && isset($_SESSION['privilage']) && $_SESSION['privilage'] == "user") {
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="../img/logo/title_logo.png">
		<link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="https://kit.fontawesome.com/d66f5928de.js" crossorigin="anonymous"></script>
		<title>Events Info - User</title>
	</head>

	<body>

		<div class="navigation"></div>

		<?php
		if (isset($_GET["msg"]) && $_GET["msg"] == "exist") {
			echo "<span id='errMsg'>Already registered for this event</span><br>";
		} else if (isset($_GET['msg']) && $_GET['msg'] == 'done') {
			echo "<span id='sucMsg'>Registered successfully</span><br>";
		}
		?>

		<div class="logo-img" style="margin-top: 90px;">
			<img src="../img/logo/logo.png" alt="College logo">
			<img src="../img/logo/naac.png" alt="NAAC logo">
		</div>

		<h1 style="margin-top: 80px;"><a href="https://erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
				<h3>(An Autonomous Institution)</h3>
			</a></h1><br>
		<h2 class="logo"><?php echo $sympName; ?> <span><?php echo $sympYear; ?></span></h2><br>

		<h3>Event Details</h3>
		<br>
		<h3 style="margin: 10px 10px  10px 10px;">TECHNICAL</h3>

		<div class="workshop">

		</div>

		<?php
		$i = 10;
		while ($row = mysqli_fetch_assoc($tech)) {
		?>
			<script>
				var btn = "<button class='btn-work tablinks <?php echo $row['TYPE']; ?>' onclick=\"popup('work<?php echo $i; ?>')\"><?php echo $row['EVENTS']; ?></button>"
				$(".workshop").append(btn);
			</script>
		<?php
			$eventName = $row['EVENTS'];
			echo "<div id='work$i' class='work'><button onclick=\"popup('work$i')\" class='cls-btn'><i class='fa-solid fa-lg fa-xmark'></i></button><div class=\"tabcontent\" id=\"des\"><h4>Description</h4>";
			echo "<p>&nbsp;" . $row['DESCRIPTION'] . "</p>";
			echo "</div><div class=\"tabcontent\" id=\"co\"><h4>Co Ordinators</h4><ul>";
			while ($coRow = mysqli_fetch_assoc($co)) {
				if ($coRow['EVENT'] == $row['EVENTS'])
					echo "<li>{$coRow['NAME']} - {$coRow['PHONE']}</li>";
			}
			mysqli_data_seek($co, 0);
			echo "</ul></div>";
			echo "<div class=\"tabcontent\" id=\"dt\"><h4>Date and Venue</h4><ul><li>DATE : {$row['DATE']}</li><li>VENUE : {$row['VENUE']}</li></ul></div><br>";
			echo "<form action='eventReg.php' method='post'><input name='sympid' value='$id' hidden><input name='event' value='" . $row['EVENTS'] . "' hidden><button id=\"reg-btn\" type='submit'>Register</button></form></div>";
			$i++;
		}
		?>

		<h3 style="margin: 10px 10px 10px 10px;">NON TECHNICAL</h3>
		<div class="event">

		</div>

		<?php
		$j = 10;
		while ($row = mysqli_fetch_assoc($nontech)) {
		?>
			<script>
				var btn = "<button class='btn-work tablinks <?php echo $row['TYPE']; ?>' onclick=\"popup('event<?php echo $j; ?>')\"><?php echo $row['EVENTS']; ?></button>";
				$(".event").append(btn);
			</script>
		<?php
			echo "<div id='event$j' class='evnt'><button onclick=\"popup('event$j')\" class='cls-btn'><i class='fa-solid fa-lg fa-xmark'></i></button><div class=\"tabcontent\" id=\"des\"><h4>Description</h4>";
			echo "<p>&nbsp;" . $row['DESCRIPTION'] . "</p></div>";
			echo "<div class=\"tabcontent\" id=\"co\"><h4>Co Ordinators</h4><ul>";
			while ($coRow = mysqli_fetch_assoc($co)) {
				if ($coRow['EVENT'] == $row['EVENTS'])
					echo "<li>{$coRow['NAME']} - {$coRow['PHONE']}</li>";
			}
			mysqli_data_seek($co, 0);
			echo "</ul></div>";
			echo "<div class=\"tabcontent\" id=\"dt\"><h4>Date and Venue</h4><table class=\"dateTable\"><tr><td>Date &nbsp;:</td><td>{$row['DATE']}</td></tr><tr><td>Venue :</td><td>{$row['VENUE']}</td></tr></table></div><br>";
			echo "<form action='eventReg.php' method='post'><input name='sympid' value='$id' hidden><input name='event' value='" . $row['EVENTS'] . "' hidden><button id=\"reg-btn\" type='submit'>Register</button></form></div>";
			$j++;
		}
		?>

		<center>
			<span class='note'><b>Note : </b> If you registered for Paper Presentation<br><button><a href="uploadFileIF.php">upload here</a></button></span>
			<span class='note'><b>Note : </b> Download all the events rules from here<br><button><a href="../Guidelines For Events.pdf">download here</a></button></span>
		</center>

		<script>
			function popup(id) {
				document.getElementById(id).classList.toggle("active");
			}

			$(document).ready(function() {
				$(".navigation").load("navbarUser.php");
				window.setTimeout(function() {
					$(".navigation > ul > li.eventInfo").addClass("active");
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

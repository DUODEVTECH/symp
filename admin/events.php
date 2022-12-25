<?php
session_start();
include "../config.php";
include "../autologout.php";
include "../sympDetail.php";

$event = mysqli_query($conn, "SELECT * FROM event");

if (isset($_SESSION['EMAIL']) && isset($_SESSION['NAME']) && isset($_SESSION['privilage']) && $_SESSION['privilage'] == "admin") {
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="../img/logo/title_logo.png">
		<title>Events List - Admin</title>
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
			<h3>EVENTS</h3><br>

			<?php
			if (isset($_GET["msg"]) && $_GET["msg"] == "ED") {
				echo "<span id='sucMsg'>Event edited successfully</span><br>";
			} else if (isset($_GET["msg"]) && $_GET["msg"] == "SOD") {
				echo "<span id='sucMsg'>Event opened successfully</span><br>";
			} else if (isset($_GET["msg"]) && $_GET["msg"] == "SCD") {
				echo "<span id='sucMsg'>Event closed successfully</span><br>";
			} else if (isset($_GET["msg"]) && $_GET["msg"] == "DD") {
				echo "<span id='sucMsg'>Event deleted successfully</span><br>";
			} else if (isset($_GET["msg"]) && $_GET["msg"] == "AD") {
				echo "<span id='sucMsg'>Event added successfully</span><br>";
			} else if (isset($_GET["msg"]) && $_GET["msg"] == "exist") {
				echo "<span id='errMsg'>Event already added</span><br>";
			}
			?>

			<br>
			<div style="overflow-x: auto;">
				<table>
					<tr>
						<th>EVENT</th>
						<th>TYPE</th>
						<th>DEPARTMENT</th>
						<th>DATE</th>
						<th>VENUE</th>
						<th>CATEGORY</th>
						<th>MAXIMUM MEMBERS</th>
						<th>EDIT</th>
						<th>STATUS</th>
						<th>DELETE</th>
					</tr>
					<?php
					$i = 10;
					while ($row = mysqli_fetch_assoc($event)) {
						$status = $row['STATUS'] == 'OPEN' ? 'CLOSE' : 'OPEN';
						$str = $row['STATUS'] == 'CLOSE' ? '' : '-open';
						$cat = $row['TEAM'] == '0' ? 'INDIVIDUAL' : 'TEAM';
						echo "<tr id='$i'>";
						echo "<td>{$row['EVENTS']}</td>";
						echo "<td>{$row['TYPE']}</td>";
						echo "<td>{$row['DEPARTMENT']}</td>";
						echo "<td>{$row['DATE']}</td>";
						echo "<td>{$row['VENUE']}</td>";
						echo "<td>{$cat}</td>";
						echo "<td>{$row['MAX_MEM']}</td>";
						echo "<td><button data-id='{$row['EVENTS']}' onclick='showEdit(this.parentNode.parentNode.id,this)'><i class='fa-solid fa-pen-to-square'></i></button></td>";
						echo "<form method='post' action='eventAct.php'><td><button type='submit' name='action' value='{$status}'><input type='hidden' name='evnt' value='{$row['EVENTS']}'><i class='fa-solid fa-lock{$str}'></i></button></td>";
						echo "<td><button type='submit' name='action' value='DELETE'><input type='hidden' name='evnt' value='{$row['EVENTS']}'><i class='fa-solid fa-trash-can'></i></button></td></form>";
						echo "</tr>";
						$i++;
					}
					?>
				</table><br>
			</div>

			<!-- Edit an Events details form -->
			<form action="eventAct.php" id="edit" method="POST" class="form">
				<input type="hidden" name="evnt" id="evnt">
				<input type="text" name="event" placeholder="Enter Event Name" id="event" required><br>
				<select name="type" id="type" required>
					<option value="-1">Select Type</option>
					<option value="TECHNICAL">TECHNICAL</option>
					<option value="NON_TECHNICAL">NON TECHNICAL</option>
				</select><br>
				<input type="text" name="dep" placeholder="Enter Department" id="dep" required><br>
				<input type="date" name="date" placeholder="Enter Date & Time" id="date" required><br>
				<input type="text" name="venue" id="venue" placeholder="Enter Venue" required><br>
				<select name="team" id="team" onchange="toggleMaxMem(this)">
					<option value="-1">TEAM OR INDIVIDUAL</option>
					<option value="0">INDIVIDUAL</option>
					<option value="1">TEAM</option>
				</select><br>
				<input type="hidden" name="max-mem" id="max-mem" placeholder="Enter Maximum Members" required><br>

				<button type="submit" name="action" value="EDIT">EDIT</button><br>
			</form><br>

			<!-- Add new event details form -->
			<button onclick="showAdd()" id="showAdd">ADD EVENT</button>
			<form id='add' action="eventAct.php" method="POST" class="form">
				<input type="text" name="event" placeholder="Enter Event Name" required><br>
				<select name="type" required>
					<option value="-1">SELECT EVENT TYPE</option>
					<option value="TECHNICAL">TECHNICAL</option>
					<option value="NON_TECHNICAL">NON TECHNICAL</option>
				</select><br>
				<input type="date" name="date" placeholder="Enter Date & Time" required><br>
				<input type="text" name="dep" placeholder="Enter Department" required><br>
				<select name="status" id="status">
					<option value="-1">SELECT STATUS</option>
					<option value="OPEN">OPEN</option>
					<option value="CLOSE">CLOSE</option>
				</select><br>
				<input type="text" name="venue" id="venue" placeholder="Enter Venue" required><br>
				<select name="team" id="team" onchange="toggleMaxMem(this)">
					<option value="-1">TEAM OR INDIVIDUAL</option>
					<option value="0">INDIVIDUAL</option>
					<option value="1">TEAM</option>
				</select><br>
				<input type="hidden" name="max-mem" id="max-mem" placeholder="Enter Maximum Members" required><br>

				<button type="submit" name="action" value="ADD">ADD</button><br>
			</form><br>
		</div>
		<script>
			// Displaying the add event form
			function showAdd() {
				var addForm = document.getElementById("add").style;
				addForm.display = (addForm.display == "block") ? "none" : "block";
			}

			// Displaying the edit event form when click event with the previous values
			function showEdit(tr, btn) {
				var editForm = document.getElementById("edit").style;
				editForm.display = (editForm.display == "block") ? "none" : "block";

				var evnt = document.getElementById(tr).childNodes[0].innerHTML.trim();
				var type = document.getElementById(tr).childNodes[1].innerHTML.trim();
				var dep = document.getElementById(tr).childNodes[2].innerHTML.trim();
				var date = document.getElementById(tr).childNodes[3].innerHTML.trim().replace(" ", "T");
				var ven = document.getElementById(tr).childNodes[4].innerHTML.trim();

				document.getElementById("type").value = type;
				document.getElementById("event").value = evnt;
				document.getElementById("date").value = date;
				document.getElementById("dep").value = dep;
				document.getElementById("venue").value = ven;

				document.getElementById('evnt').value = btn.getAttribute("data-id");
			}

			// Toggle the maximum members input when event type sets to team
			function toggleMaxMem(a){
				const maxmem = document.getElementById("max-mem");
				if(a.value == 0){
					maxmem.type = "hidden";
				} else if(a.value == 1){
					maxmem.type = "number";
				}
			}

			// Add active class to current page in navbar
			$(document).ready(function() {
				$(".navigation-admin").load("navbaradmin.php")
				window.setTimeout(function() {
					$(".navigation-admin > ul > li.eventList").addClass("active");
				}, 700);
			});
		</script>

		<br><br><br><br><br>
	</body>

	</html>

<?php
} else {
	session_unset();
	session_destroy();
	header("Location:../index.php?msg=ReLogin");
	exit();
}

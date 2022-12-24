<?php
session_start();
include "../config.php";
include "../autologout.php";
include "../sympDetail.php";

$evt = $_SESSION['EVE'];
$pos = $_SESSION['POSITION'];

if ($evt == "ENTIRE EVENT") {
	$coOrdinators = mysqli_query($conn, "SELECT * FROM coordinator WHERE EVENT != 'ENTIRE EVENT'");
} else if ($pos == "FACULTY") {
	$coOrdinators = mysqli_query($conn, "SELECT * FROM coordinator WHERE POSITION='STUDENT'");
}

if (isset($_SESSION['EMAIL']) && isset($_SESSION['NAME']) && isset($_SESSION['privilage']) && $_SESSION['privilage'] == "coordinator") {
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="../img/logo/title_logo.png">
		<title>Co-Ordinator List - Co Ordinator</title>
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

		<h1 style="margin-top: 80px;"><a href="https://www.erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
				<h3>(An Autonomous Institution)</h3>
			</a></h1><br>
		<h2 class="logo"><?php echo $sympName.' <span>'.$sympYear; ?></span></h2><br>
		<h3>CO-ORDINATORS</h3><br>


		<?php
		if (isset($_GET["msg"]) && $_GET["msg"] == "ED") {
			echo "<span id='sucMsg'>Event edited successfully</span><br>";
		} else if (isset($_GET["msg"]) && $_GET["msg"] == "DD") {
			echo "<span id='sucMsg'>Event deleted successfully</span><br>";
		} else if (isset($_GET["msg"]) && $_GET["msg"] == "AD") {
			echo "<span id='sucMsg'>Event added successfully</span><br>";
		} else if (isset($_GET["msg"]) && $_GET["msg"] == "exist") {
			echo "<span id='errMsg'>Event already added</span><br>";
		}
		?>

		<div class="search">
			<form id="search">
				<select name="filterBy" id="filterBy">
					<option value="-1">Filter By</option>
					<option value="dep">DEPARTMENT</option>
					<option value="eve">EVENT</option>
					<option value="roll">ROLL NUMBER</option>
				</select>

				<input type="text" id="input" onkeyup="filterBySearch()" placeholder="Search here...">

				<select name="pos" id="pos" onchange="filterByPos(this)">
					<option value="all">ALL</option>
					<option value="STUDENT">STUDENT</option>
					<option value="FACULTY">FACULTY</option>
				</select>
			</form>
		</div>
		<div style="overflow-x: auto;">
			<table>
				<tr>
					<th>S.NO</th>
					<th>ROLL NO</th>
					<th>NAME</th>
					<th>DEPARTMENT</th>
					<th>MOBILE</th>
					<th>EMAIL</th>
					<th>POSITION</th>
					<th>EVENT</th>
					<th>EDIT</th>
					<th>REMOVE</th>
				</tr>
				<?php
				$i = 10;
				$j =1;
				while ($row = mysqli_fetch_assoc($coOrdinators)) {
					echo "<tr id='$i'>";
					echo "<td>$j</td>";
					echo "<td>{$row['ROLLNO']}";
					echo "<td>{$row['NAME']}</td>";
					echo "<td>{$row['DEPARTMENT']}</td>";
					echo "<td>{$row['PHONE']}</td>";
					echo "<td>{$row['EMAIL']}</td>";
					echo "<td>{$row['POSITION']}</td>";
					echo "<td>{$row['EVENT']}</td>";
					echo "<td><button data-id='{$row['ROLLNO']}' onclick='showEdit(this.parentNode.parentNode.id,this)'><i class='fa-solid fa-pen-to-square'></i></button></td>";
					echo "<td><form method='post' action='coAct.php'><button type='submit' name='action' value='DELETE'><input type='hidden' name='roll' value='{$row['ROLLNO']}'><i class='fa-solid fa-trash-can'></i></button></form></td>";
					echo "</tr>";
					$i += 10;
					$j++;
				} ?>
			</table>
		</div>
		<br>

		<form action="coAct.php" id="edit" method="POST" class="form">

			<input type="hidden" name="roll" id="roll">
			<input type="text" name="name" placeholder="Enter Name" id="name" required><br>
			<input type="text" name="dep" placeholder="Enter Department" id="dep" required><br>
			<input type="text" name="pos" placeholder="Enter Position" id="posi" required><br>
			<select name="eve" id="eve">
				<option value="-1">Select Event</option>
				<?php
				$eventName = mysqli_query($conn, "SELECT EVENTS FROM event WHERE EVENTS!='$sympName'");
				if (mysqli_num_rows($eventName) > 0) {
					while ($evtName = mysqli_fetch_assoc($eventName)) {
						echo "<option value='{$evtName['EVENTS']}'>{$evtName['EVENTS']}</option>";
					}
				}
				?>
			</select><br>

			<button type="submit" name="action" value="EDIT">EDIT</button><br>
		</form><br>

		<h3>ADD CO-ORDINATORS</h3><br>
		<form action="coAct.php" method="post" class="form">

			<input type="text" name="roll" placeholder="Enter Roll Number" required><br>
			<input type="text" name="name" placeholder="Enter Name" required><br>
			<input type="email" name="email" placeholder="Enter E-Mail" required><br>
			<input type="text" name="phone" placeholder="Enter Mobile Number" required><br>
			<input type="text" name="dep" placeholder="Enter Department" required><br>
			<select name="position" id="position">
				<option value="-1">Select Position</option>
				<option value="STUDENT">Student</option>
				<option value="FACULTY">Faculty</option>
			</select><br>
			<select name="eve" id="eve">
				<option value="-1">Select Event</option>
				<?php
				$eventName = mysqli_query($conn, "SELECT EVENTS FROM event WHERE EVENTS!='$sympName'");
				if (mysqli_num_rows($eventName) > 0) {
					while ($evtName = mysqli_fetch_assoc($eventName)) {
						echo "<option value='{$evtName['EVENTS']}'>{$evtName['EVENTS']}</option>";
					}
				}
				?>
			</select><br>
			<input type="password" name="pass" placeholder="Enter Password" required><br>
			<input type="password" name="rpass" placeholder="Re-Enter Password" required><br>

			<button type="submit" name="action" value="ADD">ADD</button><br><br><br><br>
		</form>

		<script>
			function filterBySearch() {

				var filterBy, input, filter, table, tr, td, i, txtValue;

				filterBy = document.getElementById("filterBy").value;
				input = document.getElementById("input");
				filter = input.value.toUpperCase();
				table = document.getElementsByTagName("table");
				tr = document.getElementsByTagName("tr");

				filterBy = (filterBy == "dep") ? 3 : (filterBy == "eve") ? 7 : (filterBy == "roll") ? 1 : -1;
				if (filterBy == -1) {
					tr[i].style.display = "";
				} else {
					for (i = 0; i < tr.length; i++) {
						td = tr[i].getElementsByTagName("td")[filterBy];
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

			function filterByPos(a) {
				filter = a.value;
				tr = document.getElementsByTagName("tr");
				for (i = 0; i < tr.length; i++) {
					td = tr[i].getElementsByTagName("td")[5];
					if (td) {
						txtValue = td.textContent || td.innerText;
						if (txtValue.toUpperCase().indexOf(filter) > -1) {
							tr[i].style.display = "";
						} else {
							tr[i].style.display = "none";
						}
					}
					if (filter == "all") {
						tr[i].style.display = "";
					}
				}
			}

			window.onload = function faculty() {
				pos = "<?php echo $pos; ?>";
				evt = "<?php echo $evt; ?>";
				if (pos == "FACULTY" && evt != "ENTIRE EVENT") {
					select = document.getElementById("position");
					select.value = "STUDENT";
					select.disabled = true;
				}
			}


			function showEdit(tr, btn) {
				var editForm = document.getElementById("edit").style;
				editForm.display = (editForm.display == "block") ? "none" : "block";

				var name = document.getElementById(tr).childNodes[2].innerHTML;
				var dep = document.getElementById(tr).childNodes[3].innerHTML;
				var pos = document.getElementById(tr).childNodes[6].innerHTML;
				var eve = document.getElementById(tr).childNodes[7].innerHTML;

				document.getElementById("name").value = name;
				document.getElementById("dep").value = dep;
				document.getElementById("posi").value = pos;
				document.getElementById("eve").value = eve;

				document.getElementById('roll').value = btn.getAttribute("data-id");
			}

			$(document).ready(function() {
				$(".navigation").load("navbarCO.php")
				window.setTimeout(function() {
					$(".navigation > ul > li.co").addClass("active");
				}, 700);
			});
		</script>

	</body>

	</html>


<?php
	if (isset($_POST['action']) && $_POST['action'] == 'DELETE') {
		$roll = $_POST['roll'];
		mysqli_query($conn, "DELETE FROM coordinator WHERE ROLLNO='$roll'");
		header("Location: coList.php");
	}
} else {
	session_unset();
	session_destroy();
	header("Location:../index.php?msg=ReLogin");
	exit();
}

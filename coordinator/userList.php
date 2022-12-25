<?php
session_start();
include "../config.php";
include "../autologout.php";
include "../sympDetail.php";

$eve = $_SESSION['EVE'];
$sql = $_SESSION['EVE'] == 'ENTIRE EVENT' ? "SELECT * FROM users" : "SELECT * FROM users INNER JOIN user_reg_event as evtReg ON users.ID=evtReg.SYMPID WHERE evtReg.EVENT = '$eve'";

$user = mysqli_query($conn, $sql);

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
		<h3>STUDENTS</h3>

		<?php
		if (isset($_GET["msg"]) && $_GET["msg"] == "noRow") {
			echo "<span id='errMsg'>No one registered for your event</span><br>";
			unset($_GET["msg"]);
		}
		if (isset($_GET["msg"]) && $_GET["msg"] == "notsupport") {
			echo "<span id='errMsg'>File not supported</span><br>";
		}
		if (isset($_GET["msg"]) && isset($_GET["in"]) && isset($_GET["up"]) && $_GET["msg"] == "done") {
			$in = $_GET['in'];
			$up = $_GET['up'];
			echo "<span id='sucMsg'>Uploaded successfully. $in students registered and $up students updated</span><br>";
		}
		?>

		<div class="search">
			<form id="search">
				<select name="filterBy" id="filterBy">
					<option value="-1">Filter By</option>
					<option value="symp">SYMP ID</option>
					<option value="dep">DEPARTMENT</option>
					<option value="roll">ROLL NUMBER</option>
				</select>

				<input type="text" id="input" onkeyup="filterBySearch()" placeholder="Search here...">
			</form>
		</div>

		<div style="overflow-x:auto">
			<table>
				<tr>
					<th>S.NO</th>
					<th>SYMP ID</th>
					<th>NAME</th>
					<th>MOBILE</th>
					<th>EMAIL</th>
					<th>DEPARTMENT</th>
					<th>COLLEGE ROLL NO</th>
					<th>COLLEGE</th>
				</tr>
				<?php
				$i = 1;
				while ($row = mysqli_fetch_assoc($user)) {
					echo "<tr>";
					echo "<td>$i</td>";
					echo "<td>{$row['ID']}</td>";
					echo "<td>{$row['NAME']}</td>";
					echo "<td>{$row['PHONE']}</td>";
					echo "<td>{$row['EMAIL']}</td>";
					echo "<td>{$row['DEPARTMENT']}</td>";
					echo "<td>{$row['CLG_ROLL']}</td>";
					echo "<td>{$row['COLLEGE']}</td>";
					echo "</tr>";
					$i++;
				} ?>
				<tr>
					<td colspan="9">
						<button type="button" id="loadmore" data-rows="25" style="width: 200px;">LOADMORE</button>
					</td>
				</tr>
			</table>
		</div>

		<div class="dropdown">
			<button onclick="dropdown()" class="dropbtn">DOWNLOAD&nbsp;<i class="fa-solid fa-download"></i></button>
			<div id="myDropdown" class="dropdown-content" style="display: none;">
				<a href="../dnPDFUsers.php">AS PDF &nbsp;<i class="fa-solid fa-file-pdf"></i></a>
				<hr>
				<a href="../dnCSVUser.php">AS CSV &nbsp;<i class="fa-solid fa-file-excel"></i></a>
			</div>
		</div><br><br>
		
		<div class="file">
			<form action="../uploadUserCSV.php" method="POST" enctype="multipart/form-data" id="file-up-form" class="form">
				<input type="file" name="file" id="fileIn" required style="border: none;"><br><br>
				<button type="submit" name="submit" id="upbtn">UPLOAD</button><br>
				<span><b>Note:</b> Select only .csv file.</span>
			</form>
		</div>

		<script>
			function filterBySearch() {

				var filterBy, input, filter, table, tr, td, i, txtValue;

				filterBy = document.getElementById("filterBy").value;
				input = document.getElementById("input");
				filter = input.value.toUpperCase();
				table = document.getElementsByTagName("table");
				tr = document.getElementsByTagName("tr");

				filterBy = (filterBy == "symp") ? 1 : (filterBy == "dep") ? 5 : (filterBy == "roll") ? 6 : -1;
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

			window.onload = () => {
				const tr = document.getElementsByTagName('tr');
				var loadMoreBtn = document.getElementById('loadmore');
				for (let i=loadMoreBtn.dataset.rows; i < tr.length; i++){
					tr[i].style.display = "none"
				}
			};
			
			document.getElementById("loadmore").onclick = function() {
				const tr = document.getElementsByTagName('tr');
				var loadMoreBtn = document.getElementById('loadmore');
				let rows = Number(loadMoreBtn.dataset.rows);
				let max = rows+20;
				for(let i = rows; i < max; i++){
					tr[i].style.display = "";
				}
				loadMoreBtn.dataset.rows = rows + 20;
			}

			$(document).ready(function() {
				$(" .navigation").load("navbarCO.php");
				window.setTimeout(function() {
					$(".navigation> ul > li.students").addClass("active");
				}, 700);
			});


			function dropdown() {
				var div = document.getElementById("myDropdown").style;
				var dspl = div.display == "none" ? "block" : "none";
				div.display = dspl;
			}
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

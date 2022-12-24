<?php
session_start();
include "../config.php";
include "../autologout.php";
include "../sympDetail.php";

if (isset($_POST['action']) && $_POST['action'] == 'DELETE') {
	$id = $_POST['id'];
	mysqli_query($conn, "DELETE FROM users WHERE ID='$id'");
	mysqli_query($conn, "DELETE FROM user_reg_event WHERE SYMPID='$id'");
	mysqli_query($conn, "DELETE FROM feedback WHERE SYMPID='$id'");
	$file = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM ppt_files WHERE SYMPID='$id'"));
	unlink($file['PATH'] . $file['FILENAME']);
	mysqli_query($conn, "DELETE FROM ppt_files WHERE SYMPID='$id'");
	header("Location: userList.php?msg=udel");
}

$sql = "SELECT * FROM users ORDER BY ID ASC";
$result = mysqli_query($conn, $sql);

if (isset($_SESSION['EMAIL']) && isset($_SESSION['NAME']) && isset($_SESSION['privilage']) && $_SESSION['privilage'] == "admin") {
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="../img/logo/title_logo.png">
		<title>Students List - Admin</title>
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

			<h1 style="margin-top: 80px;"><a href="https://www.erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
					<h3>(An Autonomous Institution)</h3>
				</a></h1><br>
			<h2 class="logo"><?php echo $sympName.' <span>'.$sympYear; ?></span></h2><br>
			<h3>STUDENTS</h3><br>
			<?php
			if (isset($_GET["msg"]) && isset($_GET["in"]) && isset($_GET["up"]) && $_GET["msg"] == "done") {
				$in = $_GET['in'];
				$up = $_GET['up'];
				echo "<span id='sucMsg'>Uploaded successfully. $in students registered and $up students updated</span><br>";
			} else if (isset($_GET['msg']) && $_GET['msg'] == 'udel') {
				echo "<span id='sucMsg'>User deleted successfully</span>";
			} else if (isset($_GET['msg']) && $_GET['msg'] == 'send') {
				echo "<span id='sucMsg'>Mail sent successfully</span>";
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

					<select name="event" id="eventFilter" onchange="filterByEvent(this)">
						<option value="ALL">ALL USERS</option>
						<?php
							$eventsList = mysqli_query( $conn, "SELECT EVENTS FROM event WHERE EVENTS!='$sympName'");
							while($eventOption = mysqli_fetch_assoc($eventsList)){
								echo "<option value='".$eventOption['EVENTS']."'>".$eventOption['EVENTS']."</option>";
							}
						?>
					</select>
				</form>
			</div>
			<form action="../confirmationMail.php" method="post">

				<div style="overflow-x:auto">
					<table>
						<tr>
							<th>CHECK</th>
							<th>S.NO</th>
							<th>SYMP ID</th>
							<th>NAME</th>
							<th>MOBILE</th>
							<th>EMAIL</th>
							<th>DEPARTMENT</th>
							<th>COLLEGE ROLL NO</th>
							<th>COLLEGE</th>
							<th>DEL</th>
						</tr>
						<?php
						$i = 1;
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<tr>";
							$eventsData = "";
							$eventsRegisteredData = mysqli_query( $conn, "SELECT EVENT,SYMPID FROM user_reg_event WHERE SYMPID='".$row['ID']."'");
							while($eventsRegistered = mysqli_fetch_assoc($eventsRegisteredData)){
								$eventsData .= $eventsRegistered['EVENT']." ";
							}
							echo "<td class='events-registered-data' style='display: none;'>$eventsData</td>";
							echo "<td><input type='checkbox' name='ids[]' class='select' value='{$row['ID']}' onchange='btnShow()'></td>";
							echo "<td>$i</td>";
							echo "<td>{$row['ID']}</td>";
							echo "<td>{$row['NAME']}</td>";
							echo "<td>{$row['PHONE']}</td>";
							echo "<td>{$row['EMAIL']}</td>";
							echo "<td>{$row['DEPARTMENT']}</td>";
							echo "<td>{$row['CLG_ROLL']}</td>";
							echo "<td>{$row['COLLEGE']}</td>";
							echo "<td><form method='post'><button type='submit' name='action' value='DELETE'><input type='hidden' name='id' value='{$row['ID']}'><i class='fa-solid fa-trash-can'></i></button></form></td>";
							echo "</tr>";
							$lastid = $row['ID'];
							$i++;
						} ?>
					</table>
				</div><br>
				<div class="form">
					<button type="submit" name="send_mail" value="send">SEND MAIL</button>
				</div>
			</form>
					</form>

			<div class="form">
				<button type="button" id="loadmore" data-rows="25">LOADMORE</button>
			</div>

			<div class="dropdown">
				<button onclick="dropdown()" class="dropbtn">DOWNLOAD&emsp;<i class="fa-solid fa-download"></i></button>
				<div id="myDropdown" class="dropdown-content" style="display: none;">
					<a href="../dnPDFUsers.php">AS PDF &nbsp;<i class="fa-solid fa-file-pdf"></i></a>
					<hr>
					<a href="../dnCSVUser.php">AS CSV &nbsp;<i class="fa-solid fa-file-excel"></i></a>
				</div>
			</div><br><br><br>


			<div class="file">
				<form action="../uploadUserCSV.php" method="POST" enctype="multipart/form-data" id="file-up-form" class="form">
					<input type="file" name="file" id="fileIn" style="border: none;" required><br><br>
					<button type="submit" name="submit" id="upbtn">UPLOAD</button><br>
					<span><b>Note:</b> Select only .csv file.</span>
				</form>
			</div><br><br><br>
		</div>



		<script>
			function dropdown() {
				div = document.getElementById("myDropdown").style;
				var dspl = div.display == "none" ? "block" : "none";
				div.display = dspl;
			}

			function filterBySearch() {

				var filterBy, input, filter, table, tr, td, i, txtValue;

				filterBy = document.getElementById("filterBy").value;
				input = document.getElementById("input");
				filter = input.value.toUpperCase();
				table = document.getElementsByTagName("table");
				tr = document.getElementsByTagName("tr");

				filterBy = (filterBy == "symp") ? 3 : (filterBy == "dep") ? 7 : (filterBy == "roll") ? 8 : -1;

				if (filterBy == -1) {
					tr.style.display = "";
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

			function filterByEvent(a){
				var i, td, txtValue;
				const tr = document.getElementsByTagName("tr");
				
				if(a.value == "ALL"){
					for(i=0; i < tr.length; i++){
						tr[i].style.display = "";
					}
				} else {
					for(i=0; i <  tr.length; i++){
						td = tr[i].getElementsByTagName('td')[0];
						if(td){
							txtValue = td.textContent || td.innerText;
							if(txtValue.toUpperCase().indexOf(a.value) > -1){
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
				$(".navigation-admin").load("navbaradmin.php")
				window.setTimeout(function() {
					$(".navigation-admin > ul > li.students").addClass("active");
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

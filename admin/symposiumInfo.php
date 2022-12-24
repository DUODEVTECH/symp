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
        <title>Symposium Info Edit</title>
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
            <h2 class="logo"><?php echo $sympName.' <span>'.$sympYear; ?></span></h2><br><br>

			<?php 
			if(isset($_GET["msg"]) && $_GET["msg"] == "pw"){
				echo "<span id='sucMsg'>Email and Password changed successfully.</span>";
			} else if(isset($_GET['msg']) && $_GET['msg'] == "nmc"){
				echo "<span id='sucMsg'>Symposium name updated successfully.</span>";
			} else if(isset($_GET['msg']) && $_GET['msg'] == "link"){
				echo "<span id='sucMsg'>Social Media links were updated successfully.</span>";
			} else if(isset($_GET['msg']) && $_GET['msg'] == "fco"){
				echo "<span id='sucMsg'>Co-Ordinators updated successfully.</span>";
			} else if(isset($_GET['msg']) && $_GET['msg'] == "ap"){
				echo "<span id='sucMsg'>App Password updated successfully.</span>";
			} else if(isset($_GET['msg']) && $_GET['msg'] == "img"){
				echo "<span id='sucMsg'>Image uploaded successfully.</span>";
			} else if(isset($_GET['msg']) && $_GET['msg'] == "abt"){
				echo "<span id='sucMsg'>Vision updated successfully.</span>";
			}
			?>


            <div class="basic">

				<!-- SYMPOSIUM NAME & DATE INPUT -->
				<h3>SYMPOSIUM INFO EDIT</h3>
				<form action="symposiumInfoUpdate.php" method="POST" class="form">
                    <div class="input-group">
                        <label for="symp-name">Symposium Name :</label>
                        <input type="text" name="symp_name" id="symp-name">
                    </div>
                    <div class="input-group">
                        <label for="symp-date">Date :</label>
                        <input type="datetime-local" name="date" id="symp-date">
                    </div>
                    <button type="submit" name="save-btn" value="name">SAVE</button>
                </form>


				<br>
				<!-- Symposium Social Media Links -->
                <h3>Links</h3>
                <form action="symposiumInfoUpdate.php" method="POST" class="form">
                    <div class="input-group">
                        <label for="instagram">Instagram :</label>
                        <input type="text" name="in_link" id="instagram">
                    </div>
                    <div class="input-group">
                        <label for="whatsapp">WhatsApp :</label>
                        <input type="text" name="wa_link" id="whatsapp">
                    </div>
                    <button type="submit" name="save-btn" value="link">SAVE</button>
                </form>


				<br>
				<!-- Symposium Co Ordinators For Footer -->
                <h3>Co-Ordinators</h3>
                <form action="symposiumInfoUpdate.php" method="POST" class="form">
                    <div class="input-group">
                        <label for="fac-co-1">Faculty 1 :</label>
                        <input type="text" name="fac-co-1" id="fac-co-1">
                    </div>
                    <div class="input-group">
						<label for="fac-co-1-num">Facult 1 Number :</label>
						<input type="number" name="fac-co-1-num" id="fac-co-1-num" onkeydown="validate_phone(this)">
					</div>
                    <div class="input-group">
						<label for="fac-co-2">Faculty 2 :</label>
						<input type="text" name="fac-co-2" id="fac-co-1">
					</div>
                    <div class="input-group">
						<label for="fac-co-2-num">Faculty 2 Number :</label>
						<input type="number" name="fac-co-2-num" id="fac-co-2-num" onkeydown="validate_phone(this)">
					</div>
                    <div class="input-group">
						<label for="std-1">Student 1 :</label>
						<input type="text" name="std-1" id="std-1">
					</div>
                    <div class="input-group">
						<label for="std-1-num">Student 1 number :</label>
						<input type="number" name="std-1-num" id="std-1-num" onkeydown="validate_phone(this)">
					</div>
                    <div class="input-group">
						<label for="std-2">Student 2 :</label>
						<input type="text" name="std-2" id="std-2">
					</div>
                    <div class="input-group">
						<label for="std-2-num">Student 2 number :</label>
						<input type="number" name="std-2-num" id="std-2-num" onkeydown="validate_phone(this)">
					</div>
					<button type="submit" name="save-btn" value="co">SAVE</button>
                </form>


				<br>
				<!-- PHPMailer Login Details -->
				<h3>Mail Details</h3>
				<form action="symposiumInfoUpdate.php" method="post" class="form">
					<div class="input-group">
						<label for="pass">App Password :</label>
						<input type="text" name="app_pass" id="pass">
					</div>
					<button type="submit" name="save-btn" value="app">SAVE</button>
				</form>


				<br>
				<!-- Change Admin Credentials -->
				<h3>Change Login Credential</h3>
				<form action="symposiumInfoUpdate.php" method="post" class="form">
					<div class="input-group">
						<label for="email">E-Mail :</label>
						<input type="email" name="email" id="email" required>
					</div>
					<div class="input-group">
						<label for="new_pass">New Password :</label>
						<input type="text" name="new_pass" id="new_pass" required>
					</div>
					<button type="submit" name="save-btn" value="pass">SAVE</button>
				</form>
				
				<br>
				<!-- Logo and Poster Upload -->
				<h3>Logo and Poster</h3>
				<form action="symposiumInfoUpdate.php" method="post" class="form" enctype="multipart/form-data">
					<div class="input-group">
						<label for="title-logo">Title Logo (1:1) :</label>
						<input type="file" name="title-logo" id="title-logo" accept="image/png">
						<span></span>
					</div>
					<div class="input-group">
						<label for="about-img">About image (1:1) :</label>
						<input type="file" name="abt-img" id="about-img" accept="image/jpeg, image/png">
					</div>
					<div class="input-group">
						<label for="f-img">Footer Logo (16:9) :</label>
						<input type="file" name="f-img" id="f-img" accept="image/png">
					</div>
					<div class="input-group">
						<label for="poster">Poster image (16:9) :</label>
						<input type="file" name="poster" id="poster" accept="image/jpeg">
					</div>
					<button type="submit" name="save-btn" value="img">SAVE</button>
				</form>

				<br>
				<!-- About vision change -->
				<h3>Symposium Vision</h3>
				<form action="symposiumInfoUpdate.php" method="post" class="form">
                    <div class="input-group">
                        <label for="symp-vision">Vision of Symposium:</label>
                        <textarea name="symp-vision" id="symp-vision" cols="20" rows="5"></textarea>
                    </div>
                    <button type="submit" name="save-btn" value="about">SAVE</button>
                </form>
            </div>

			<div class="updated-details">
				<table>
					<tr>
						<th width="60%">Detail</th>
						<th width="40%">Data</th>
					</tr>
					<tr>
						<td>Symposium Name</td>
						<td><?php echo $sympName.' '.$sympYear; ?></td>
					</tr>
					<tr>
						<td>Date</td>
						<td><?php echo $sympDate; ?></td>
					</tr>
					<tr>
						<td>VISION</td>
						<td><?php echo $sympVision; ?></td>
					</tr>
					<tr>
						<th colspan="2">LINKS</th>
					</tr>
					<tr>
						<td>Instagram</td>
						<td><?php echo $sympIn; ?></td>
					</tr>
					<tr>
						<td>WhatsApp</td>
						<td><?php echo $sympWa; ?></td>
					</tr>
					<tr>
						<th colspan="2">CO-ORDINATORS</th>
					</tr>
					<tr>
						<td>Facult 1</td>
						<td><?php echo $sympFac1; ?></td>
					</tr>
					<tr>
						<td>Faculty 1 Number</td>
						<td><?php echo $sympFac1Num; ?></td>
					</tr>
					<tr>
						<td>Faculty 2</td>
						<td><?php echo $sympFac2; ?></td>
					</tr>
					<tr>
						<td>Faculty 2 Number</td>
						<td><?php echo $sympFac2Num; ?></td>
					</tr>
					<tr>
						<td>Student 1</td>
						<td><?php echo $sympStd1; ?></td>
					</tr>
					<tr>
						<td>Student 1 Number</td>
						<td><?php echo $sympStd1Num; ?></td>
					</tr>
					<tr>
						<td>Student 2</td>
						<td><?php echo $sympStd2; ?></td>
					</tr>
					<tr>
						<td>Student 2 Number</td>
						<td><?php echo $sympStd2Num; ?></td>
					</tr>
					<tr>
						<th colspan="2">MAIL DETAILS</th>
					</tr>
					<tr>
						<td>Mail ID</td>
						<td><?php echo $sympEmail; ?></td>
					</tr>
					<tr>
						<td>App Password</td>
						<td><?php echo $sympAppPass; ?></td>
					</tr>
					<tr>
						<th colspan="2">IMAGES</th>
					</tr>
					<tr>
						<td>Title Logo</td>
						<td><img src="../img/logo/title_logo.png" alt="Title logo" id="title-img"></td>
					</tr>
					<tr>
						<td>About Image</td>
						<td><img src="../img/logo/abount_img.jpg" alt="About Image" id="abt-img"></td>
					</tr>
					<tr>
						<td>Footer Logo</td>
						<td><img src="../img/logo/footer_img.png" alt="Footer Logo" id="f-img"></td>
					</tr>
					<tr>
						<td>Poster</td>
						<td><img src="../img/logo/poster.jpg" alt="Symposium Poster" id="poster"></td>
					</tr>
				</table>
			</div>
			<br><br>
        </div>

        <script>
            $(document).ready(function() {
                $(".navigation-admin").load("navbaradmin.php")
                window.setTimeout(function() {
                    $(".navigation-admin > ul > li.symposium-info").addClass("active");
                }, 700);
            });

			function validate_phone(a){
				if(!(a.value.match(/[6-9]{1,}[0-9]{9}/g))){
					a.style.borderColor = "#ff3f34"
				}else{
					a.style.borderColor = "#00000080"
				}
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

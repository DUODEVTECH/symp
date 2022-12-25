<?php
session_start();
include "../config.php";
include "../autologout.php";
include "../sympDetail.php";

$id    = $_SESSION['ID'];
$reg   = 0;
$check = mysqli_query($conn, "SELECT * FROM ppt_files WHERE TL='$id' OR TEAM_2='$id' OR TEAM_3='$id'");
if (mysqli_num_rows($check) > 0)
    $reg = 1;
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
        <title>PPT Upload - User</title>
    </head>

    <body>

        <div class="navigation"></div>

        <?php
        if (isset($_GET['msg']) && $_GET['msg'] == "upload") {
            echo "<span id='errMsg'>Upload your file first.</span>";
        }
        if (isset($_GET['msg']) && $_GET['msg'] == "fileNotSupport") {
            echo "<span id='errMsg'>Please upload .ppt and .pptx file only.</span>";
        }
        if (isset($_GET['msg']) && $_GET['msg'] == "alreadyUploaded") {
            echo "<span id='errMsg'>You already uploaded this file. If you want to reupload, first delete the file below and then try again.</span>";
        }
        if (isset($_GET['msg']) && $_GET['msg'] == "notSupport") {
            echo "<span id='errMsg'>Your file not supported.</span>";
        }
        if (isset($_GET['msg']) && $_GET['msg'] == "uploaded") {
            echo "<span id='sucMsg'>Your file is uploaded successfully</span>";
        }
        if (isset($_GET['msg']) && $_GET['msg'] == "nouser") {
            echo "<span id='errMsg'>Team leader or Team mate ID is invalid. Please check and Try again.</span>";
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

        <h3>Upload Paper Presentation File</h3>
        <br><br><br>

        <form action="uploadFile.php" method="POST" enctype="multipart/form-data" id="uploadForm" class="form" autocomplete="off">
            <input type="text" name="tl" placeholder="Enter Team Leader ID" required><br> 
            <input type="text" name="tm2" placeholder="Enter Team Mate 1 ID (optional)"><br>
            <input type="text" name="tm3" placeholder="Enter Team Mate 2 ID (optional)"><br>

            <input type="text" name='topic' id='topic' placeholder="Enter your topic" required><br>
            <textarea name="abstract" id="abstract" placeholder="Enter Abstract" cols="15" rows="4" required></textarea><br>
            <input type="file" name='ppt' accept=".ppt, .pptx, .doc, .docx, .pdf" id='ppt' style="border: none;" required><br>
            <label for="ppt" style="font-size: 12px; color: red;"><b>Note :</b> Only select .ppt .pptx .doc .docx .pdf files &<br> file size should be less than 10MB.</label><br>
            
            <button type="submit" name='submit' value='upload' id='upload'>UPLOAD</button><br>
        </form>

        <div class="file-dn" style="overflow-x: auto;">
            <table>
                <tr>
                    <th>TEAM LEADER</th>
                    <th>TEAM MATE 1</th>
                    <th>TEAM MATE 2</th>
                    <th>TOPIC</th>
                    <th>ABSTRACT</th>
                    <th>DELETE</th>
                </tr>
                <tr>
                    <?php
                    if (mysqli_num_rows($check) > 0) {
                        while ($file = mysqli_fetch_assoc($check)) {
                            $tl = mysqli_fetch_assoc(mysqli_query( $conn, "SELECT ID, NAME FROM users WHERE ID='{$file['TL']}'"));
                            $tm2 = mysqli_fetch_assoc(mysqli_query( $conn, "SELECT ID, NAME FROM users WHERE ID='{$file['TEAM_2']}'"));
                            $tm3 = mysqli_fetch_assoc(mysqli_query( $conn, "SELECT ID, NAME FROM users WHERE ID='{$file['TEAM_3']}'"));
                            echo "<td>{$tl['ID']} {$tl['NAME']}</td>";
                            echo "<td>{$tm2['ID']} {$tm2['NAME']}</td>";
                            echo "<td>{$tm3['ID']} {$tm3['NAME']}</td>";
                            echo "<td>{$file['TOPIC']}</td>";
                            echo "<td>{$file['ABSTRACT']}</td>";
                            echo "<td><form method='post' action='uploadFile.php'><input type='hidden' name='id' value='{$file['TL']}'><button type='submit' name='submit' value='delete'><i class='fa-solid fa-sm fa-trash-can'></i></button></form></td></td>";
                        }
                    }
                    ?>
                </tr>
            </table>
        </div>
        
        <script>
            $("#ppt").change(function() {
                var size = this.files[0].size;
                size /= (1024 * 1024);
                if (size > 10) {
                    alert("File size cannot be more than 10 MB");
                    $("#ppt").val('');
                }
            });

            var reg = <?php echo $reg; ?>;
            if (reg == 1) {
                $("#uploadForm").css("display", "none");
                $(".file-dn").css("display", "block");
            } else {
                $("#uploadForm").css("display", "block");
                $(".file-dn").css("display", "none");
            }

            $(document).ready(function() {
                $(".navigation").load("navbarUser.php");
                window.setTimeout(function() {
                    $(".navigation > ul > li.upload").addClass("active");
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

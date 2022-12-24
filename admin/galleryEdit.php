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
    <title>Gallery Edit - Admin</title>
    <link rel="icon" href="../img/logo/title_logo.png">
    <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d66f5928de.js" crossorigin="anonymous"></script>
</head>
<body class="admin-panel">

    <div class="navigation-admin"></div>

    <div class="wrapper">

        <?php 
        if(isset($_GET['msg']) && $_GET['msg'] == "notSupport"){
            echo "<span id='errMsg'>Please select a valid image.</span>";
        }
        if(isset($_GET['msg']) && $_GET['msg'] == "uploaded"){
            echo "<span id='sucMsg'>Image uploaded successfully.</span>";
        }
        if(isset($_GET['msg']) && $_GET['msg'] == "cannotUpload"){
            echo "<span id='errMsg'>Can't upload image. Please try again.</span>";
        }
        if(isset($_GET['msg']) && $_GET['msg'] == "deleted"){
            echo "<span id='sucMsg'>Image deleted successfully.</span>";
        }
        if(isset($_GET['msg']) && $_GET['msg'] == "cannotDelete"){
            echo "<span id='errMsg'>Can't delete image. Please try again later.</span>";
        }
        ?>

        <div class="logo-img" style="margin-top: 90px;">
            <img src="../img/logo/logo.png" alt="College logo">
            <img src="../img/logo/naac.png" alt="NAAC logo">
        </div>

        <h1 style="margin-top: 80px;">
            <a href="https://www.erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
                <h3>(An Autonomous Institution)</h3>
            </a>
        </h1><br>
        <h2 class="logo"><?php echo $sympName." <span>".$sympYear ?></span></h2><br>

        <h3>GALLERY EDIT</h3>
        <br><br><br>

        <form action="uploadGalleryImage.php" method="post" enctype="multipart/form-data" class="form-img">
            <input type="file" name="img" id="img-up" accept=".png, .jpg, .jpeg" required><br>
            
            <input type="radio" name="folder" value="../img/gallery/" id="f-g" required>
            <label for="f-g">EVENTS</label><br>
            
            <input type="radio" name="folder" value="../img/winners/" id="f-p">
            <label for="f-p">PRIZE</label><br>
            
            <button type="submit" name="save-btn" value="save">SAVE</button>
        </form>

        <br><br>
        <h3>EVENTS PHOTO PREVIEW</h3>
        <section class="photo-gallery">
            <?php
                $files = glob("../img/gallery/*.*");
                for ($i = 0; $i < count($files); $i++) {
                    $image = $files[$i];
                    echo '<img src="' . $image . '" alt="Gallery image" class="img" data-name="../img/gallery/'.basename($image).'">';
                }
            ?>
        </section>
        <br><br>
        <h3>PRICE PHOTO PREVIEW</h3>
        <section class="photo-gallery">
            <?php
                $files = glob("../img/winners/*.*");
                for ($i = 0; $i < count($files); $i++) {
                    $image = $files[$i];
                    echo '<img src="'.$image.'" alt="Winners image" class="img" data-name="../img/winners/'.basename($image).'">';
                }?>
        </section>
    </div>
    <div id="modal" style="width: calc(100vw - 80px);">
        <form action="uploadGalleryImage.php" method="post">
            <input type="hidden" name="file-name" value="" id="img-name">
            <button type="submit" name="save-btn" value="delete" class="delete"><i class="fa-solid fa-trash-can"></i></button>
        </form>
        <span class="close"><i class="fa-solid fa-xmark"></i></span>
    </div>
    <script>
        const modal = document.getElementById("modal");
        const input = document.getElementById("img-name");
        const images = document.querySelectorAll(".img");
        images.forEach( image => {
            image.addEventListener('click', ()=>{
                modal.classList.add('active')
                const img = document.createElement('img');
                img.id = 'img';
                img.src = image.src;
                input.value = image.dataset.name;
                while(modal.children.length > 2){
                    modal.removeChild(modal.lastChild);
                }
                modal.append(img);
            });
        });

        const close = document.querySelector("#modal .close");
        close.addEventListener('click', () => {
            modal.classList.remove('active');
        });

        $(document).ready(function() {
            $(".navigation-admin").load("navbaradmin.php");
            window.setTimeout(function() {
                $(".navigation-admin > ul > li.gallery").addClass("active");
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
?>
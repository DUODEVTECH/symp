<?php
session_start();
include "config.php";
include "sympDetail.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $sympName;?> - Gallery</title>
    <link rel="icon" href="img/logo/title_logo.png">
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d66f5928de.js" crossorigin="anonymous"></script>
</head>
<body>

    <div class="logo-img" style="margin-top: 90px;">
        <img src="img/logo/logo.png" alt="College logo">
        <img src="img/logo/naac.png" alt="NAAC logo">
    </div>
    
    <h1 style="margin-top: 80px;"><a href="https://www.erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
            <h3>(An Autonomous Institution)</h3>
        </a></h1>

    <div class="tabcontent" id="gallery">
    <br><br><br>
    <h3>OUR GALLERY</h3>
    <section class="photo-gallery">
        <?php
            $files = glob("img/gallery/*.*");
            for ($i = 0; $i < count($files); $i++) {
                $image = $files[$i];
                echo '<img src="' . $image . '" alt="Gallery image" class="img">';
            }
        ?>
    </section>
    
    <script>
        const modal = document.createElement('div');
        modal.id = "modal";
        document.body.appendChild(modal);

        const images = document.querySelectorAll(".img");
        images.forEach( image => {
            image.addEventListener('click', ()=>{
                modal.classList.add('active')
                const img = document.createElement('img');
                img.id = 'img';
                img.src = image.src;
                while(modal.firstChild){
                    modal.removeChild(modal.firstChild);
                }
                modal.append(img);
            });
        });


        modal.addEventListener('click', ()=>{
            modal.classList.remove('active');
        });
    </script>
</div>
</body>
</html>

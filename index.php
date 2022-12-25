<?php
session_start();
include "config.php";
include "sympDetail.php";

if (isset($_SESSION['privilage'])) {
    header("Location: logout.php");
}

$date = mysqli_fetch_assoc(mysqli_query($conn, "SELECT DATE,STATUS FROM event WHERE EVENTS='".$sympName."'"));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $sympName; ?> is an National level Technical Symposium conducted by Computer Science and Engineering Department Erode Sengunthar Engineering College.">
    <title><?php echo $sympName." ".$sympYear; ?> - A National Level Technical Symposium</title>
    <link rel="icon" href="img/logo/title_logo.png">
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <script src="js/ButtonTab.js?<?php echo time(); ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d66f5928de.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php
    if (isset($_GET["msg"]) && $_GET["msg"] == "exist") {
        echo "<span id='errMsg'>Already registered please log in to your account</span>";
        unset($_GET['msg']);
    } else if (isset($_GET["msg"]) && $_GET["msg"] == 'failed') {
        echo "<span id='errMsg'>Invalid Username or Password</span>";
    } else if (isset($_GET["msg"]) && $_GET["msg"] == 'passResetDone') {
        echo "<span id='sucMsg'>Password changed successfully</span>";
    } else if (isset($_GET["msg"]) && $_GET["msg"] == "ReLogin") {
        echo "<span id='errMsg'>Please login again</span>";
    } else if (isset($_GET["msg"]) && $_GET["msg"] == "mailsent") {
        echo "<span id='sucMsg'>Your mail has been sent successfully. Please wait for the reply.</span>";
    } else if (isset($_GET["msg"]) && $_GET["msg"] == "mailnotsent") {
        echo "<span id='errMsg'>Your mail not sent. Please sent it again.</span>";
    } else if (isset($_GET["msg"]) && $_GET["msg"] == "regdone") {
        echo "<span id='sucMsg'>Your registration was success. You can Login your account for registering events</span>";
        ?>
        <script>
            $("#login-btn").trigger("click");
        </script>
        <?php
    }
    ?>

    <marquee behavior="scroll" direction="left" id="recent-registrations">
        <?php 
            $recentRegistration = mysqli_query( $conn, "SELECT NAME, COLLEGE FROM users ORDER BY REG_TIME DESC LIMIT 3");
            while($recentRegistrationRow = mysqli_fetch_assoc($recentRegistration)){
                echo "<span>".$recentRegistrationRow['NAME']." from ".$recentRegistrationRow['COLLEGE']." is registered for symposium.&emsp;</span>";
            }
        ?>
    </marquee>
    <div class="logo-img" style="margin-top: 90px;">
        <img src="img/logo/logo.png" alt="College logo">
        <img src="img/logo/naac.png" alt="NAAC logo">
    </div>
    
    <h1 style="margin-top: 80px;"><a href="https://erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
            <h3>(An Autonomous Institution)</h3>
        </a></h1>
    <nav class="nav-index">
        <label class="logo"><?php echo $sympName; ?> <span><?php echo $sympYear; ?></span></label>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtnlbl">
            <i class="fa-solid fa-bars open"></i>
            <i class="fa-solid fa-xmark"></i>
        </label>
        <ul>
            <li><button class="tablinks  active" onclick="openTab(this,'home'); closeMenu(this);">Home</button></li>
            <li><button class="tablinks " onclick="openTab(this,'event'); closeMenu(this);">Events</button></li>
            <li><button class="tablinks " id="login-btn" onclick="openTab(this,'login'); closeMenu(this);">Login</button></li>
            <?php 
            if($date['STATUS'] == 'OPEN'){
                ?>
                <li><button class="tablinks " onclick="openTab(this, 'register'); closeMenu(this);">Register</button></li>
            <?php
             } ?>
            <li><button class="tablinks " onclick="openTab(this,'contact'); closeMenu(this);">Contact us</button></li>
        </ul>
    </nav>



    <div class="tabcontent" id="home">
        <br><br><br>

        <div id="timer">
            <div id="timerDIV">
                <div>
                    <span id="days"></span>
                    <span>Days</span>
                </div>
                <div>
                    <span id="hour"></span>
                    <span>Hours</span>
                </div>
                <div>
                    <span id="min"></span>
                    <span>Minutes</span>
                </div>
                <div>
                    <span id="sec"></span>
                    <span>Seconds</span>
                </div>
            </div>
        </div>

        <div id="celebration">

            <br>
            <p id='sympDay'>&emsp;&emsp; Symposium of Erode Sengunthar Engineering College is happening now.
                Everyone is participating is in the Events.
                Registered student can participate in the Symposium.
                Students can also register in offline mode on the event day.
            </p><br>
        </div>
        <br>
        <marquee behavior="scroll" direction="left" style="font-weight: bold; margin: 0 10% 20px 10%;">LOGIN to register for the events.</marquee>
        <div class="details">
            <br>
            <p id="info">&emsp;&emsp;Every year, Erode Sengunthar Engineering College conducts a National Level Technical Symposium for the students.
                Students can join by registering on this website. Students can pay the registration fees only on the spot. Registration starts on October 03, 2022.
            </p><br>

            <div class="poster">
                <center><img src="img/logo/poster.jpg" alt="Symposium poster"></center>
                <div class="register-here">
                    <center>
                        <p>Not yet registered?</p><br>
                        <button class="tablinks" onclick="openTab(this, 'register'); closeMenu(this);">Register Here!</button>
                    </center>
                </div>
            </div>
            <br>
        </div>

        <section class="timeline-section">
            <div class="timeline-items">
            <?php
                $res = mysqli_query($conn, "SELECT * FROM event WHERE EVENTS != '".$sympName."' AND STATUS='OPEN' ORDER BY DATE ASC");
                if (mysqli_num_rows($res) > 0) {
                    while ($eveRow = mysqli_fetch_assoc($res)) {
                        $timeline = "<div class='timeline-item'><div class='timeline-dot'></div><div class='timeline-date'>{$eveRow['DATE']}</div><div class='timeline-content'><h3>{$eveRow['EVENTS']}</h3><p>{$eveRow['DESCRIPTION']}</p></div></div>";
                        echo $timeline;
                    }
                }
            ?>
            </div>
        </section>

        <section class="gallery">
            <h3>OUR GALLERY</h3>
            <div class="photo-gallery">
                <?php 
                    $fils = glob("img/gallery/*.*");
                    $count = count($fils)>=4?4:count($fils);
                    for($i=0; $i<$count; $i++){
                        $img = $fils[$i];
                        echo "<img src='$img' alt='gallery image'>";
                    }
                ?>
            </div>
            <br>
            <div class="form">
                <a href="gallery.php"><button>View More</button></a>
            </div>
            <br><br>
        </section>

        <div class="venue">
            <h3>Venue</h3><br>
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3289.829560726306!2d77.54868872648142!3d11.313594846099218!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba9132f4f89e445%3A0x81f682bd38f8a702!2sErode%20Sengunthar%20Engineering%20College!5e0!3m2!1sen!2sin!4v1659877416438!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

    </div>


    <div class="tabcontent" id="event" style="display: none;">
        <br><br><br>
        <select name="filter" id="dep-filter">
            <option value="ALL">ALL</option>
            <option value="TECHNICAL">TECHNICAL</option>
            <option value="NON_TECHNICAL">NON-TECHNICAL</option>
        </select>

        <div class="event"></div>
        <?php
        $event = mysqli_query($conn, "SELECT * FROM event WHERE EVENTS!='".$sympName."' AND STATUS='OPEN' ");
        $co    = mysqli_query($conn, "SELECT NAME, PHONE, EVENT FROM coordinator");
        $i = 10;
        mysqli_data_seek($event, 0);
        while ($row = mysqli_fetch_assoc($event)) {
        ?>
            <script>
                var btn = "<button class='btn-work tablinks <?php echo $row['TYPE']; ?>' onclick=\"popup('work<?php echo $i; ?>')\"><?php echo $row['EVENTS']; ?></button>";
                $(".event").append(btn);
            </script>
        <?php
            $eventName = $row['EVENTS'];
            echo "<div id='work$i' class='work'><button onclick=\"popup('work$i')\" class='cls-btn'><i class='fa-solid fa-lg fa-xmark'></i></button><div id=\"des\"><h4>Description</h4>";
            echo "<p>&nbsp;" . $row['DESCRIPTION'] . "</p></div>";
            echo "<div id=\"co\"><h4>Co Ordinators</h4><ul>";
            while ($coRow = mysqli_fetch_assoc($co)) {
                if ($coRow['EVENT'] == $row['EVENTS'])
                    echo "<li>{$coRow['NAME']} - {$coRow['PHONE']}</li>";
            }
            mysqli_data_seek($co, 0);
            echo "</ul></div>";
            echo "<div id=\"dt\"><h4>DATE & VENUE</h4><ul><li>DATE : {$row['DATE']}</li><li>VENUE : {$row['VENUE']}</li></ul></div></div><br>";
            $i++;
        }
        ?>
    </div>

    <br><br>
    <div class="tabcontent" id="login">


        <h3>LOGIN</h3>
        <div class="form">
            <form action="login.php" method="post" id="form">

                <input type="text" placeholder="Email ID" name="uname" id="email1" onchange="validation()" autocomplete="off" required><br>
                <input type="password" placeholder="Password" name="password" class="pass1" required><br>

                <input type="checkbox" onclick="showPass()" id="show">
                <label for="show" id="lb1">Show Password</label><br>
                <span id='forgot'>Forgotten password? <a href="reset_password/forgot_password.php">Click here</a></span><br>
                <button type="submit" id="loginBtn" disabled>LOGIN</button>
            </form>
        </div>
    </div>

        <br><br>
    <div class="tabcontent" id="register">
        <h3>REGISTER</h3>
        <div class="form">
            <form action="register.php" method="post" autocomplete="off">

                <input type="text" placeholder="Name" name="name" onchange="validate_register(this)" required><br>
                <input type="text" placeholder="College RollNo" name="clg_roll" onchange="validate_register(this)" required><br>
                <input type="email" placeholder="E-mail" name="email" id="email2" onchange="validate(); validate_register(this);" required><br>
                <input type="phone" placeholder="Phone Number" name="phone" onchange="validate_register(this)" onkeydown="validate_phone(this)" required><br>
                <input type="text" placeholder="College Name" name="clg" onchange="validate_register(this)" required><br>
                
                <select name="deg" id="deg">
                    <option value="-1">Select Degree</option>
                    <option value="BE">BE</option>
                    <option value="BTECH">BTECH</option>
                    <option value="ME">ME</option>
                    <option value="MTECH">MTECH</option>
                </select><br>
                <input type="text" placeholder="Department" name="dep" onchange="validate_register(this)" required><br>
                <select name="year" id="year">
                    <option value="-1">Select Year</option>
                    <option value="I">I</option>
                    <option value="II">II</option>
                    <option value="III">III</option>
                    <option value="IV">IV</option>
                    <option value="V">V</option>
                </select><br>
                <input type="password" placeholder="Password" name="password" class="pass1" id="pass" onchange="validate_register(this);" required><br>
                <input type="password" placeholder="Re-type Password" name="r_password" class="pass1" id="rpass" onchange="validate_register(this);" onkeydown="validate_pass();" required><br>

                <input type="checkbox" onclick="showPass()" id="show1">
                <label for="show" id="lb2">Show Password</label><br>

                <button type="submit" id="regBtn">REGISTER</button>
            </form>
        </div>
    </div>

    <div class="tabcontent" id="contact">
        <br><br><br>

        <div class="contact">
            <div class="contact-details">
                <h3 style="text-align: center; margin: 20px;">Details</h3>
                <h4><i class="fa-solid fa-map">&nbsp; </i>Address :</h4>
                <p>ERODE SENGUNTHAR<br>ENGINEERING COLLEGE<br>PERUNDURAI, ERODE - 638057</p><br>
                <h4><i class="fa-solid fa-at">&nbsp; </i>E-Mail :</h4>
                <p><?php echo $sympEmail; ?></p><br>
                <h4><i class="fa-solid fa-phone">&nbsp; </i>Phone :</h4>
                <p><?php echo $sympFac1." - ".$sympFac1Num;?></p>
                <p><?php echo $sympFac2." - ".$sympFac2Num;?></p>
            </div>
            <div class="form">
                <h3 style="margin: 20px;">Contact Us</h3>
                <form action="contact.php" method="POST" autocomplete="off">
                    <input type="text" name="name" placeholder="Enter your name" required><br>
                    <input type="email" name="email" placeholder="Enter your email" required><br>
                    <input type="text" name="sub" placeholder="Enter subject" required><br>
                    <textarea name="msg" id="msg" rows="7" placeholder="Enter your message"></textarea><br><br>
                    <button type="submit" name="contact">Send</button>
                </form>
            </div>
        </div>

    </div>
    <br><br>

    <footer class="footer">
        <div class="container">
            <div class="row">

                <div class="footer-col" style="padding: 0;">
                    <img src="img/logo/footer_img.png" alt="Symposium logo" width="250px">
                </div>

                <div class="footer-col">
                    <h4>follow us</h4>
                    <div class="social-links">
                        <a href="<?php echo $sympIn;?>"><i class="fa-brands fa-xl fa-lg fa-instagram"></i></a>
                        <a href="<?php echo $sympWa;?>"><i class="fa-brands fa-xl fa-whatsapp"></i></a>
                        <a href="https://t.me/+sqmIWv6B-j0wM2U1"><i class="fa-brands fa-xl fa-telegram"></i></a>
                    </div>
                </div>

                <div class="footer-col">
                    <h4>Faculty Contact</h4>
                    <ul>
                        <li><a href="tel:+91<?php echo $sympFac1Num;?>"><?php echo $sympFac1." - ".$sympFac1Num;?></a></li><br>
                        <li><a href="tel:+91<?php echo $sympFac2Num;?>"><?php echo $sympFac2." - ".$sympFac2Num; ?></a></li><br>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Student Contact</h4>
                    <ul>
                        <li><a href="tel:+91<?php echo $sympStd1Num;?>"><?php echo $sympStd1." - ".$sympStd1Num;?></a></li><br>
                        <li><a href="tel:+91<?php echo $sympStd2Num;?>"><?php echo $sympStd2." - ".$sympStd2Num;?></a></li><br>
                    </ul>
                </div>

            </div>
        </div>
        <hr style="border: 1px solid rgba(255, 255, 255, 0.3);"><br>
        <center><span class="duodev"><a href="https://duodev.in" style="text-decoration: none; color: white;">&copy; DuoDev</a> &emsp;Developed BY - E K JAYAPRAKASH (BE CSE) / K HARIHARAN (BE CSE)</span></center>
    </footer>

    <script>
        function validation() {
            var log_btn = document.getElementById("loginBtn");
            var log_email = document.getElementById("email1").value


            var emailPattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

            log_btn.disabled = (log_email.match(emailPattern) || !(log_email == "")) ? false : true;
        }

        function closeMenu(a) {
            $("#check").prop("checked", false)
        }


        $(function() {
            var nav = $(".nav-index");
            $(window).scroll(function() {
                var scroll = $(window).scrollTop();

                if (scroll >= 155) {
                    nav.addClass("bg");
                } else {
                    nav.removeClass("bg");
                }
            });
        });

        function popup(id) {
            document.getElementById(id).classList.toggle("active");
        }

        $("#dep-filter").change(function() {
            filter = this.value;
            if (filter == "ALL") {
                $(".btn-work").show();
            } else {
                $(".btn-work").show();
                $(".btn-work").not("." + filter).hide();
            }
        });

        function showPass() {
            var x = document.getElementsByClassName("pass1");
            for (i = 0; i < x.length; i++) {
                if (x[i].type === "password") {
                    x[i].type = "text";
                } else {
                    x[i].type = "password";
                }
            }
        }

        function validate_phone(a){
            if(!(a.value.match(/[6-9]{1,}[0-9]{9}/g))){
                a.style.borderColor = "#ff3f34"
            }else{
                a.style.borderColor = "#00000080"
            }
		}

        function validate_register(a) {
            regBtn = document.getElementById("regBtn");
            if (a.value.replace(/\s+/g, '').length == 0) {
                $("body").append("<span id='errMsg'>Enter valid details</span>")
                regBtn.disabled = true;
            } else {
                regBtn.disabled = false;
            }
        }

        function validate_pass() {
            var pass = document.getElementById("pass");
            var rpass = document.getElementById("rpass");

            if (pass != rpass) {
                rpass.style.borderBottom = "3px solid red";
            }
        }

        var date = "<?php echo $date['DATE']; ?>".replace(" ", "T");

        var countDownDate = new Date(date).getTime();
        console.log(date);
        var now = new Date().getTime();

        function eventDate() {
            var now = new Date().getTime();

            var dTag = document.getElementById("days");
            var hTag = document.getElementById("hour");
            var mTag = document.getElementById("min");
            var sTag = document.getElementById("sec");

            var distance = countDownDate - now;
            const second = 1000;
            const minute = second * 60;
            const hour = minute * 60;
            const day = hour * 24;

            const d = Math.floor(distance / day);
            const h = Math.floor((distance % day) / hour);
            const m = Math.floor((distance % hour) / minute);
            const s = Math.floor((distance % minute) / second);

            if (distance > 0) {
                document.getElementById('timer').style = "display:block";
                dTag.innerText = d;
                hTag.innerText = h;
                mTag.innerText = m;
                sTag.innerText = s;
            } else {
                document.getElementById('timer').style = "display:none";
                document.getElementById('timerDIV').style = "border:none";
                document.getElementById('sympDay').style = "display:block";
                clearInterval(timer);
            }
        }
        const timer = setInterval(function() {
            eventDate();
        }, 1000);
    </script>
</body>

</html>
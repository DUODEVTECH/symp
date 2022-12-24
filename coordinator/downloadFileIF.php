<?php
session_start();
include "../config.php";
include "../autologout.php";
include "../sympDetail.php";

if (isset($_SESSION['EMAIL']) && isset($_SESSION['NAME']) && isset($_SESSION['privilage']) && $_SESSION['privilage'] == "coordinator") {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../img/logo/title_logo.png">
        <title>Download PPT files - Co Ordinator</title>
        <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/d66f5928de.js" crossorigin="anonymous"></script>
    </head>

    <body>

        <div class="navigation"></div>


        <?php
        if (isset($_GET['msg']) && $_GET['msg'] == 'SA') {
            echo "<span id='sucMsg'>All students selected for Paper Presentation</span>";
        } else if (isset($_GET['msg']) && $_GET['msg'] == 'SO') {
            echo "<span id='sucMsg'>Selected successfully</span>";
        } else if (isset($_GET['msg']) && $_GET['msg'] == 'RO') {
            echo "<span id='sucMsg'>Rejected successfully</span>";
        } else if (isset($_GET['msg']) && $_GET['msg'] == 'cantDN') {
            echo "<span id='errMsg'>Can't download all files at this moment. Please try again</span>";
        } else if (isset($_GET['msg']) && $_GET['msg'] == 'sent') {
            echo "<span id='sucMsg'>Mail sent successfully to all users.</span>";
        } else if (isset($_GET['msg']) && $_GET['msg'] == 'notsend' && isset($_GET['id'])) {
            $id = $_GET['id'];
            echo "<span id='errMsg'>Mail not sent to $id</span>";
        } else if (isset($_GET['msg']) && $_GET['msg'] == 'nouser') {
            echo "<span id='errMsg'>No users were registered for the Paper Presentation.</span>";
        }
        ?>

        <div class="logo-img" style="margin-top: 90px;">
            <img src="../img/logo/logo.png" alt="College logo">
            <img src="../img/logo/naac.png" alt="NAAC logo">
        </div>

        <h1 style="margin-top: 80px;"><a href="https://www.erode-sengunthar.ac.in/">ERODE SENGUNTHAR<br><span>ENGINEERING COLLEGE </span> <br>
                <h3>(An Autonomous Institution)</h3>
            </a></h1><br>
        <h2 class="logo"><?php echo $sympName.' <span>'.$sympYear; ?></span></h2><br>
        <h3>DOWNLOAD PPT</h3><br>

        <div class="search">
            <form id="search">

                <input type="text" id="input" onkeyup="filterBySearch()" placeholder="Search here...">

                <select name="pay" id="pay" onchange="filterByResult(this)">
                    <option value="all">ALL</option>
                    <option value="SELECTED">SELECTED</option>
                    <option value="REJECTED">REJECTED</option>
                </select>
            </form>
        </div>

        <div class="file-dn" id="file-dn">
            <div style="overflow-x: auto;">
            <table>
                    <tr>
                        <th>CHECK</th>
                        <th>TEAM LEADER</th>
                        <th>TEAM MEMBER 1</th>
                        <th>TEAM MEMBER 2</th>
                        <th>TOPIC</th>
                        <th>ABSTRACT</th>
                        <th>DOWNLOAD</th>
                        <th>RESULT</th>
                        <th>REJECT</th>
                    </tr>
                    <?php
                    $files = mysqli_query($conn, "SELECT * FROM ppt_files");
                    if (mysqli_num_rows($files) > 0) {
                        while ($file = mysqli_fetch_assoc($files)) {
                            $disabled = ($file['RESULT'] == 'REJECTED') ? "disabled='true'" : "";
                            echo "<tr><td><form><input type='checkbox' name='ids[]' class='select' value='{$file['TL']}' onchange='btnShow()'></form></td><td>{$file['TL']}</td><td>{$file['TEAM_2']}</td><td>{$file['TEAM_3']}</td><td>{$file['TOPIC']}</td><td>{$file['ABSTRACT']}</td><td><form method='post' action='downloadFile.php'><input type='hidden' name='id' value='{$file['TL']}'><input type='hidden' name='topic' value='{$file['TOPIC']}'><button type='submit' name='submit' value='single'><i class='fa-solid fa-sm fa-download'></i></button></form></td><td>{$file['RESULT']}</td><td><form method='post' action='downloadFile.php'><input type='hidden' name='id' value='{$file['TL']}'><button type='submit' name='submit' value='reject' style='background: red;' $disabled><i class='fa-solid fa-sm fa-ban'></i></button></form></td></tr>";
                        }
                    } else {
                        $noFile =  "<tr><td colspan='9'><p style='text-align:center; color:black;'>No files were uploaded for selection.</p></td></tr>";
                    ?>
                        <script>
                            var tr = "<?php echo $noFile; ?>";
                            $(".file-dn > table").append(tr);
                        </script>
                    <?php
                    }
                    ?>
                </table>
            </div>
            
        </div>
        <div class=" form" style="display:flex; justify-content: center; flex-wrap:wrap;">
                <br><br>
                <button type="submit" id='selected' name="submit" value="selectALL" style="width: 200px; margin: 30px 20px;" onclick="selectALL(this)">SELECT ALL</button>
                <form action="downloadFile.php" method="post"><button type='submit' name='submit' value='all' style="width: 200px; margin: 30px 20px;">DOWNLOAD ALL</button></form>
                <form action="downloadFile.php" method="post"><button type='submit' name='submit' value='send' style='width: 200px; margin: 30px 20px;'>SEND MAIL</button></form>
                <a href="../downloadAbstractCSV.php" style="margin: 25px 20px;"><button type="button">DOWNLOAD ABSTRACT</button></a>
            </div>
        <script>
            function btnShow() {
                var checkbox = document.getElementsByClassName("select");
                for (i = 0; i < checkbox.length; i++) {
                    if (checkbox[i].checked) {
                        document.getElementById("selected").innerHTML = "SELECT";
                        document.getElementById("selected").value = "selectChecked";

                        document.getElementById("selected").addEventListener("click", function() {
                            sendDATA(this);
                        });

                        break;
                    } else {
                        document.getElementById("selected").innerHTML = "SELECT ALL";
                        document.getElementById("selected").value = "selectALL";

                        document.getElementById("selected").addEventListener("click", function() {
                            selectALL(this);
                        });
                    }
                }
            }

            function sendDATA(a) {
                var checkbox = document.getElementsByClassName("select");
                ids = [];
                j = 0;
                for (i = 0; i < checkbox.length; i++) {
                    if (checkbox[i].checked) {
                        ids[j] = checkbox[i].value;
                        j++;
                    }
                }

                $.ajax({
                    method: "post",
                    url: "downloadFile.php",
                    data: {
                        submit: a.value,
                        ids: ids,
                    },
                    dataType: "text",
                    success: function(response) {
                        window.location.href = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + "msg=SO";
                    }
                });
            }

            function selectALL(a) {
                $.ajax({
                    type: "post",
                    url: "downloadFile.php",
                    data: {
                        submit: a.value,
                    },
                    dataType: "text",
                    success: function(response) {
                        window.location.href = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + "msg=SA";

                    }
                });
            }

            function filterBySearch() {

                var input, filter, table, tr, td, i, txtValue;

                input = document.getElementById("input");
                filter = input.value.toUpperCase();
                table = document.getElementsByTagName("table");
                tr = document.getElementsByTagName("tr");

                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[1];
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


            function filterByResult(a) {
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

            $(document).ready(function() {
                $(".navigation").load("navbarCO.php")
                window.setTimeout(function() {
                    $(".navigation > ul > li.download").addClass("active");
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

<?php
session_start();
date_default_timezone_set("Asia/Calcutta");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classroom";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['coursecode'])) {
        $_SESSION['coursecode'] = $_POST['coursecode'];
    }
    $coursecode = $_SESSION['coursecode'];
    if (isset($_POST['announcement'])) {
        $email = $_SESSION["studentEmail"];
        
        $announcement = $_POST["announcement"];
        $date_clicked = date('Y-m-d H:i:s');
        $_SESSION['date_clicked'] = $date_clicked;
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql3 = "INSERT INTO announcements(coursecode,date,announce,email) VALUES ('$coursecode','$date_clicked','$announcement','$email')";
        $res = $conn->query($sql3);
        $conn->close();
    }
    if (isset($_POST['submit_comment'])) {
        $conn = new mysqli($servername, $username, $password, $dbname);
        $comment = $_POST['comment'];
        $msg_date = $_POST['date'];
        $rec_email = $_POST['email'];
        $sender_email = $_SESSION['studentEmail'];
        $live_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO comments(comment,sender_email,receiver_email,sender_date,msg_date) VALUES('$comment','$sender_email','$rec_email','$live_date','$msg_date')";
        $conn->query($sql);
        $conn->close();
    }
}
$conn = new mysqli($servername, $username, $password, $dbname);
$coursecode = $_SESSION['coursecode'];
$sql = "SELECT coursename,subject FROM courses WHERE coursecode='$coursecode'";
$resu = $conn->query($sql);
$display = $resu->fetch_assoc();
$conn->close();
?>
<html>

<head>
    <style>
        .one_announce {
            padding-left: 20px;
            width: 60%;
            border: 1.5px solid #D0D0D0;
            border-radius: 10px;
            margin: 10px auto 10px auto;
            word-wrap: break-word;
        }

        .date {
            position: relative;
            bottom: 17px;
        }

        .date1 {
            position: relative;
            bottom: 17px;
        }

        .comm {
            position: relative;
            bottom: 21px;
        }

        .comm1 {
            position: relative;
            bottom: 13px;
        }

        .btn {
            margin-bottom: 10px;
            background-color: white;
            border-color: white;
        }
        .in {
            border: 1px solid #B5B5B5;
        }

        body {
            background-color: white;
        }

        .announce {
            margin-left: 15%;
            margin-right: 15%;
            border-radius: 10px;
            background-color: #ABD9FF;

            padding-left: 20px;
            width: 60%;
            /* border: 1px solid black; */
            border-radius: 8px;
            margin: 10px auto 10px auto;
            word-wrap: break-word;
        }

        .one_announce {
            padding-left: 20px;
            width: 60%;
            /* border: 1px solid black; */
            border-radius: 8px;
            margin: 10px auto 10px auto;
            word-wrap: break-word;
            background-color: #F2F2F2;
        }

        .bar {
            display: flex;
            justify-content: space-around;
            padding-bottom: 40px;
        }

        .home {
            position: relative;
            right: 136px;
            top: 20px;

        }


        .test {
            position: relative;
            left: 450px;
            top: 20px;
        }

        .asssection {
            position: relative;
            left: 136px;
            top: 20px;
        }

        .topbtn {
            background-color: #81C6E8;
            border: none;
            color: white;

            padding: 6px 24px;
            text-decoration: none;
            margin: 6px 2px;
            cursor: pointer;
            border-radius: 10px;
        }

        .topbtn:hover {
            transform: scale(1.1);
        }

        .postbtn {
            background-color: #81C6E8;
            border: solid black;
            border-width: 1px;
            color: white;
            padding: 10px 24px;
            text-decoration: none;
            margin: 6px 2px;
            cursor: pointer;
            border-radius: 10px;
        }

        .postbtn:hover {
            transform: scale(1.1);
        }

        .areatext {
            border-radius: 11px;
            width: 95%;

        }

        .ig {
            width: 98%;
            object-fit: contain;
            margin-top: 21px;
            border-radius: 9px;
        }
        .btn33{
            position: relative;
            bottom: 10px;
        }
    </style>
</head>

<body>


    <body>
        <div class="bar">
            <div class="home">
                <form action="stHome.php">
                    <input class="topbtn" type='submit' value='HOME'>
                </form>
            </div>
            <div class="test">
                <form action="studentTest.php" method="post">
                    <input class="topbtn" type="submit" value="TESTS">
                </form>

            </div>
            <div class="asssection">
                <form action="submitassignment.php" method="post">
                    <input class="topbtn" type="submit" name="submitassignment" value="ASSIGNMENT">
                </form>
            </div>
        </div>
        <div class="announce">
            <img src="./images/img3.png" alt="Class Photo" class="ig">
            <h1><?php echo $display['coursename'] . ":" . $display['subject'] ?></h1>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <textarea class="areatext" rows="3" name="announcement" cols="100" placeholder="Announce Something To Your Class" required></textarea>
                <br><br>
                <input class="postbtn" type="submit" name="click" value="POST">
            </form>
        </div>

        <?php
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql2 = "SELECT announce,date,email FROM announcements WHERE coursecode='$coursecode' ORDER BY date DESC";
        $res = $conn->query($sql2);
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $e = $row['email'];
                $a = $row['announce'];
                $d = $row['date'];
                $goodd = strtotime($d);
                $goodd = date('M d h:i', $goodd);
                //$conn = new mysqli($servername, $username, $password, $dbname);
                $sql4 = "SELECT firstname,lastname FROM students WHERE email='$e' UNION SELECT firstname,lastname FROM professors WHERE email='$e'";
                $pr = $conn->query($sql4);
                $pr_name = $pr->fetch_assoc();
                $full_name = $pr_name['firstname'] . " " . $pr_name['lastname'];
                echo "<div class='one_announce'>
            <form action='studentAnnouncements.php' method='post'>
            <input type='hidden' value='$d' name='date'>
            <input type='hidden' value='$e' name='email'>
            </form>" ?>
                <?php
                echo "
            <h4 class='fname'>$full_name</h4>
            <p class='date'>$goodd</p>
            <p class='comm'>$a</p>
            <form action='studentAnnouncements.php' method='post'>
            <input type='hidden' value='$d' name='date'>
            <input type='hidden' value='$e' name='email'>
            <input class='in' type='text' placeholder='Add a class comment...' name='comment' size='110' style='height: 35px;border-radius: 10px;'required>
            <input class='sub' class='btn33' type='submit' value='Post' name='submit_comment'>
            </form>
            ";
                ?>
                <button class='btn' class='postbtn' onclick='showcomments(<?php echo strtotime($d); ?>)'><img src='./images/comm.png' width="120px" height="30px"></img></button>
        <?php
                $sqlcomm = "SELECT * FROM comments WHERE msg_date='$d' AND receiver_email='$e' ORDER BY sender_date DESC";
                $kk = strtotime($d);
                $res100 = $conn->query($sqlcomm);
                echo "<div id='$kk' style='display:none'>";
                if ($res100->num_rows > 0) {
                    while ($r2 = $res100->fetch_assoc()) {
                        $se = $r2['sender_email'];
                        $cp = $r2['comment'];
                        $sd = $r2['sender_date'];
                        $sql41 = "SELECT firstname,lastname FROM students WHERE email='$se' UNION SELECT firstname,lastname FROM professors WHERE email='$se'";
                        $pro = $conn->query($sql41);
                        $pro_name = $pro->fetch_assoc();
                        $f_name = $pro_name['firstname'] . " " . $pro_name['lastname'];
                        $good2 = strtotime($sd);
                        $good2 = date('M d h:i', $good2);
                        echo "
                    <hr>
                    <div>
                    <h4 class='fname1'>$f_name</h4>
                    <p class='date1'>$good2</p>
                    <p class='comm1'>$cp</p>
                    </div>";
                    }
                } else {
                    echo "<h4>No comments yet</h4>";
                }
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<h1>No announcements</h1>";
        }
        $conn->close();
        ?>
        <script>
            function showcomments(y) {
                var x = document.getElementById(y);
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            }
        </script>
    </body>

</html>
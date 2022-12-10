<?php
session_start();
date_default_timezone_set("Asia/Calcutta");


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classroom";


try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "CREATE TABLE IF NOT EXISTS announcements (
        coursecode VARCHAR(255)  ,
        `date` datetime ,
        announce longtext ,
        email varchar(255) 
        )";
    $conn->query($sql);
    $conn->close();
} catch (Exception $e) {
    echo "";
}




try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "CREATE TABLE IF NOT EXISTS comments (
        comment longtext  ,
        sender_email varchar(255) ,
        receiver_email varchar(255) ,
        sender_date datetime ,
        msg_date datetime 
        )";
    $conn->query($sql);
    $conn->close();
} catch (Exception $e) {
    echo "";
}



try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "CREATE TABLE IF NOT EXISTS test_question (
        question varchar(255) ,
        answer int ,
        testId int ,
        questionId int 
        )";
    $conn->query($sql);
    $conn->close();
} catch (Exception $e) {
    echo "";
}


try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "CREATE TABLE IF NOT EXISTS studentcourses (
        coursecode varchar(255),
        student_email varchar(255)
        )";
    $conn->query($sql);
    $conn->close();
} catch (Exception $e) {
    echo "";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['coursecode'])) {
        $_SESSION['coursecode'] = $_POST['coursecode'];
    }
    $coursecode = $_SESSION['coursecode'];
    if (isset($_POST['announcement'])) {
        $email = $_SESSION["email"];
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
        $sender_email = $_SESSION['email'];
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

        .comm {
            position: relative;
            bottom: 21px;
        }

        .btn {
            margin-bottom: 10px;
            background-color: white;
            border-color: white;
        }

        .in {
            border: 1px solid #B5B5B5;
        }
    </style>
</head>

<body>
    <div class="bar">
        <div class="home">
            <form action="professorHome.php">
                <input class="topbtn" type='submit' value='HOME'>
            </form>

        </div>
        <div class="test">
            <form method="post" action="createTest.php">
                <input class="topbtn" type="submit" value="Create Test">
            </form>

        </div>
        <div class="asssection">
            <form method="post" action="proftest.php">
                <input class="topbtn" type="submit" value="Tests">
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
            $sql4 = "SELECT firstname,lastname FROM students WHERE email='$e' UNION SELECT firstname,lastname FROM professors WHERE email='$e'";
            $pr = $conn->query($sql4);
            $pr_name = $pr->fetch_assoc();
            $full_name = $pr_name['firstname'] . " " . $pr_name['lastname'];
            echo "<div class='one_announce'>
            <form action='profAnnouncements.php' method='post'>
            <input type='hidden' value='$d' name='date'>
            <input type='hidden' value='$e' name='email'>
            </form>" ?>
            <?php
            echo "
            <h4 class='fname'>$full_name</h4>
            <p class='date'>$goodd</p>
            <p class='comm'>$a</p>
            <form action='profAnnouncements.php' method='post'>
            <input type='hidden' value='$d' name='date'>
            <input type='hidden' value='$e' name='email'>
            <input class='in' type='text' placeholder='Add a class comment...' name='comment' size='110' style='height: 35px;border-radius: 10px;'required>
            <input class='sub' type='submit' value='Post' name='submit_comment'>
            </form>
            ";
            ?>
            <button class='btn' onclick='showcomments(<?php echo strtotime($d); ?>)'><img src='./images/comm.png' width="120px" height="30px"></img></button>
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
                    <h4>$f_name</h4>
                    </h4>$good2</h4>
                    <p>$cp</p>
                    </div>
                    
                    ";
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
    echo "
<script>
function showcomments(y){
    var x= document.getElementById(y);
    if (x.style.display === 'none') {
            x.style.display = 'block';
    } else {
            x.style.display = 'none';
    }
}
</script>
";
    ?>
</body>

</html>
<style>
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
</style>
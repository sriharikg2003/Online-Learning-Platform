<?php
session_start();

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if (!isset($_SESSION['studentEmail'])) {


    echo '<script>
        alert("Unauthorized access. Please Login!");
        window.location = "index.php";
    </script>';
}

?>

<!DOCTYPE html>
<html>

<head>
    <style>
        .entercoursecode {
            outline: 0;
            border-width: 0 0 2px;
            border-color: blue;
            margin-bottom: 16px;

        }

        .enroll {
            margin-left: 80%;
            margin-top: 20px;
        }

        .rollbtn {
            padding: 2px;
            border: none;
            background-color: #87A2FB;
            color: #EEEEEE;
            padding: 10px 37px;
            text-align: center;
            border-radius: 5px;
            display: inline;
            border-width: 1px;
            border-color: darkblue;
            cursor: pointer;
        }

        body {
            font-family: Verdana, sans-serif;
        }

        .course-name {
            margin-top: 0;
            color: white;
            cursor: pointer;
        }

        .number {
            color: white;
            margin-top: 70px;
        }

        .one {
            margin: 25px;
            width: 275px;
            height: 265px;
            border: 1px solid #B7C4CF;
            border-radius: 10px;
        }

        .one:hover {
            box-shadow: 2.5px 2.5px #DADBDB;
        }

        .flex {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            flex-direction: row;
            align-content: center;
        }

        .sub:hover {
            text-decoration: underline;
            text-decoration-thickness: 2px;
        }

        .sub {
            text-align: left;
            width: 250px;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        .bottom {
            padding-left: 10px;
        }

        .kk {
            margin-bottom: 30px;
            color: #909090;
        }

        .inner {
            margin-top: 0;
            padding: 10px;
            background-color: #F96666;
            width: 255px;
            height: 130px;
            border-radius: 10px 10px 0 0;
            margin-bottom: 0px;
        }

        .pp {
            color: #6B728E;
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
    </style>
</head>

<body>
   

    
    <div class="bar">
       
        <form action="logout.php">
                <input class="topbtn" type='submit' value='Logout'>
            </form>

            <form action="changePasswordStu.php">
            <input class="topbtn" type='submit' value='Change Password'>
            </form>
            

        </div>
        <?php
        
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "classroom";
       $semail= $_SESSION['studentEmail'];
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "SELECT * FROM students WHERE email='$semail'";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $fname = $row['firstname'];
    $lname = $row['lastname'];
    echo "<h2>Welcome Student . ".$fname ." ".$lname."</h2>"; 
        ?>

        <div class="enroll">
            <!-- <div class="enroll"> -->
            <form action="stHome.php" method="post">
                <input class="entercoursecode" type="text" name='coursecode' placeholder="Enter coursecode" onclick="hi()" required>
                <input class="rollbtn" type="submit" value="ENROLL">
            </form>
        </div>
    </div>


    <?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "classroom";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $semail = $_SESSION['studentEmail'];
        $coursecode = $_SESSION['coursecode'] = test_input($_POST['coursecode']);
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql5 = "SELECT studentcourses.coursecode FROM studentcourses,courses WHERE studentcourses.coursecode='$coursecode' AND studentcourses.student_email='$semail';";
        $co = $conn->query($sql5);
        $conn->close();
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql6 = "SELECT coursecode FROM courses WHERE coursecode='$coursecode';";
        $arr1 = $conn->query($sql6);
        $conn->close();
        if ($co->num_rows > 0 && $arr1->num_rows > 0) {
            echo "<script>alert('You have already enrolled')</script>";
        } else if ($arr1->num_rows == 0) {
            echo "<script>alert('Invalid Course Code')</script>";
        } else {
            $k = $_SESSION['coursecode'];
            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql3 = "INSERT INTO studentcourses(student_email,coursecode) VALUES('$semail','$k')";
            $conn->query($sql3);
            $conn->close();
        }
    }
    $semail = $_SESSION["studentEmail"];
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "SELECT courses.coursename AS coursename,courses.coursecode AS coursecode ,courses.subject 
AS subject FROM courses, studentcourses WHERE 
courses.coursecode=studentcourses.coursecode AND student_email='$semail';";
    $result = $conn->query($sql);
    echo "<h1 style='color:#390879'>Running Courses:</h1>";
    if ($result->num_rows > 0) {
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            // $subject = $_SESSION['subject'];
            // $coursename = $_SESSION['coursename'];
            //echo $row["coursename"]."<br>";
            $c = $row['coursename'];
            $d = $row['subject'];
            $cc = $row['coursecode'];
            $sql10 = "SELECT * FROM studentcourses WHERE coursecode='$cc';";
            $sql100 = "SELECT * FROM professors,courses WHERE courses.coursecode='$cc' AND courses.profemail=professors.email";
            $parr = $conn->query($sql10);
            $rows = $parr->num_rows;
            $bows = $conn->query($sql100);
            $bows = $bows->fetch_assoc();
            $f = $bows['firstname'];
            $l = $bows['lastname'];
            echo "<div class='flex'>
      <div class='one'>
          <div class='inner'>
          <form id='view_form' method='post' action='studentAnnouncements.php'>
          <input name='coursecode' type='hidden' value='$cc'>
          <div class='heyy'>
          <input type='submit' title='$c:$d' class='sub' value='$c:$d'> 
          </div>
          </form>
          <h3 class='number'>$rows students</h3>
          </div>
          <div class='bottom'>
          <h4 class='kk'>Course code: $cc</h4>
          <hr>
          <h4 class='pp'>$f $l</h4>
          </div>
      </div>";
        }
    } else {
        echo "<h1>No courses</h1>";
    }
    $conn->close();
    ?>
    <script>
        colors = ["#6FEDD6", "#F96666", "#87A2FB", "#8758FF", "#5F6F94", "#F7A76C", "#73A9AD", "#7858A6", "#8CC0DE", "#B4FF9F"];
        var elements = document.getElementsByClassName('inner');
        var k = document.getElementsByClassName('sub');
        for (var i = 0; i < elements.length; i++) {
            elements[i].style.backgroundColor = colors[i];
            k[i].style.backgroundColor = colors[i];
            k[i].style.color = "white";
            k[i].style.border = "none";
            k[i].style.cursor = "pointer";
            k[i].style.fontSize = "25px";
            k[i].style.fontFamily = "Verdana";
        }
    </script>
</body>

</html>
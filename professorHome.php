<?php
session_start();

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_SESSION['studentEmail'])) {


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
        .asssection {
            position: relative;
            left: 136px;
            top: 20px;
        }

        .inner {
            margin-top: 0;
            padding: 10px;
            background-color: #F96666;
            width: 255px;
            height: 120px;
            border-radius: 10px 10px 0 0;
            margin-bottom: 0px;
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
            align-content: space-between;
            flex-direction: row;

        }

        .sub:hover {
            text-decoration: underline;
            text-decoration-thickness: 2px;
        }

        .sub {
            width: 250px;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        .bottom {
            padding-left: 10px;
            height: 50px;

        }

        .kk {
            margin-bottom: 30px;
            color: #909090;
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

        .bar {
            display: flex;
            justify-content: space-around;
            padding-bottom: 40px;
        }

        .home {
            position: relative;
            right: 228px;
            top: 20px;
        }
    </style>
</head>

<body>



    </div>


    <div class="bar">
        <div class="home">
            <form action="logout.php">
                <input class="topbtn" type='submit' value='Logout'>
            </form>


            <form action="changePassword.php">
            <input class="topbtn" type='submit' value='Change Password'>
            </form>
        </div>

        <div class="asssection">
            <form action="professorCreateCourse.php">
                <input class="topbtn" type="submit" value="Create Course">
            </form>

        </div>
    </div>


    <?php

    $email = $_SESSION["email"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "classroom";

    
  $conn = new mysqli($servername, $username, $password, $dbname);
  $sql = "SELECT * FROM professors WHERE email='$email'";

  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $fname = $row['firstname'];
  $lname = $row['lastname'];
  echo "<h2>Welcome Prof. ".$fname ." ".$lname."</h2>"; 

    try {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "CREATE TABLE courses (profemail varchar(255),coursename varchar(255), coursecode varchar(255) PRIMARY KEY)";
        if ($conn->query($sql) === TRUE) {
            echo "Table created successfully";
        } else {
            echo "Error creating table: " . $conn->error;
        }

        $conn->close();
    } catch (Exception $e) {
        echo "";
    }
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT coursename,coursecode,subject FROM courses WHERE profemail='$email'";
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
            $parr = $conn->query($sql10);
            $rows = $parr->num_rows;
            echo "<div class='flex'>
      <div class='one'>
          <div class='inner'>
          <form id='view_form' method='post' action='profAnnouncements.php'>
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
          <form action='scheduleClass.php' method='post'>
          <input name='coursecode' type='hidden' value='$cc'>
          <input name='courseName' type='hidden' value='$c'>          
          <input type='submit' title='Schedule Class'  value='Schedule Class'>
          </form>
 
          <form action='Assignment.php' method='post'>
          <input name='courseName' type='hidden' value='$c'> 
          <input name='course-code' type='hidden' value='$cc'>          
          <input type='submit' title='Assignment'  value='Assignment'>
          </form>
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
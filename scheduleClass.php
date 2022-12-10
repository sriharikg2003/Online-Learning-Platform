<!DOCTYPE html>
<html>

<body>


  <link rel="stylesheet" href="schedclass.css">

  <div class="asssection">
    <form action="professorHome.php">
      <input class="topbtn" type='submit' value='HOME'>
    </form>

  </div>

  <style>
    .asssection {
      position: absolute;
      right: 57px;
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
  </style>



  <?php
  session_start();


  if (!isset($_SESSION['email'])) {
    echo '

    <script>
      alert("Unauthorized access. Please Login!");
      window.location = "index.php";
    </script>
';
  }
  
  



  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  $profemail = $_SESSION["email"];
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "classroom";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['coursecode'])) {
      $coursecode = $_SESSION['coursecode'] = $_POST['coursecode'];

      $_SESSION['courseName'] = $courseName = $_POST['courseName'];
      try {
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        // Create database
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

      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      $courseSelected;
      $sql = "SELECT coursename FROM courses WHERE coursecode='$coursecode'";

      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      $courseName = $row['coursename'];
    }
  }
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "classroom";
  $profemail = $_SESSION["email"];
  $courseName = $_SESSION['courseName'];
  $coursecode = $_SESSION['coursecode'];
  date_default_timezone_set("Asia/Calcutta");

  $conn = new mysqli($servername, $username, $password, $dbname);
  $sql = "SELECT * FROM professors WHERE email='$profemail'";

  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $fname = $row['firstname'];
  $lname = $row['lastname'];

  ?>

  <div class='container'>
    <h2>Schedule <?php echo $courseName  ?> Class</h2><br>
    <div class="mess">
      <form action="scheduleClass.php" method="post">
        Date : <br>
        <input class="i" type="date" name="dateOfClass" required><br>
        Time<br>
        <input class="i" type="time" name="timeOfClass" required><br>
        Gmeet Link :
        <input class="i" type="text" name="gmeetLink" required><br>
        <input class="i" type="hidden" name="courseName" value="<?php echo $courseName ?>">
        <input class="i" type="hidden" name="coursecode" value="<?php echo $coursecode ?>">
        <input class="i" type=submit value="Schedule class">
    </div>
    </form>
  </div>



  <?php

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['timeOfClass']) && isset($_POST['dateOfClass']) && isset($_POST['gmeetLink']) && isset($_POST['courseName']) &&  isset($_POST['coursecode'])) {
      $_SESSION['date'] = $date = $_POST['dateOfClass'];
      $_SESSION['time'] = $time = $_POST['timeOfClass'];
      $profemail = $_SESSION['email'];
      $_SESSION['courseName'] = $courseName = $_POST['courseName'];
      $_SESSION['gmeetLink'] = $gmeetLink =  $_POST['gmeetLink'];
      $coursecode = $_POST['coursecode'];
      $date_clicked = date('Y-m-d H:i:s');
      $_SESSION['date_clicked'] = $date_clicked;
      $coursecode = $_SESSION['coursecode'];
      $announcement = "Dear Students, you have a class scheduled on $date at $time ";
      $sqlimpp = "INSERT INTO announcements(coursecode,date,announce,email) VALUES ('$coursecode','$date_clicked','$announcement','$profemail')";
      $conn = new mysqli($servername, $username, $password, $dbname);
      $conn->query($sqlimpp);
      $conn->close();
      $conn = new mysqli($servername, $username, $password, $dbname);
      $sql = "CREATE TABLE if not exists `classtime` (courseName varchar(255),`date` date, `time` time,`profemail` varchar(255),`gmeetLink` varchar(255)) ";

      $conn->query($sql);

      $sql5 = "INSERT INTO classtime (courseName,date,time,profemail,gmeetLink)
                VALUES ('$courseName','$date','$time','$profemail','$gmeetLink')";
      if ($conn->query($sql5) === TRUE) {
        $message = $courseName . " Class has been scheduled on " . $date . " at " . $time . " with Gmeet link " . $gmeetLink;
        header("Location:mailClass.php");
      } else {
        echo "<div class='notify'>Class not scheduled</div>";
      }
    }
  }
  ?>


</body>



</html>
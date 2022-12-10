<!-- create submission table if not exist pending -->

<!-- files as of now pdf only   resolved  -->
<!DOCTYPE html>
<html>

    <head>
<style>
    * {
    box-sizing: border-box;
    padding: 0%;
    margin: 0%;
    font-family: 'Open Sans', sans-serif;
}

.box {
    display: flow-root;
    margin: auto;
    width: 60%;
    border: 1px solid black;
    border-radius: 8px;
    margin: 10px auto 10px auto;
    word-wrap: break-word;
    background-color: #abd9ff;
    text-align: left;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
    margin-bottom: 15px;
    align-content: space-around;
}
.download {
    height: 25px;
    width: 25px;
}

.left {
    display: inline;
    float: left;
}

.right {
    display: inline;
    float: right;
}
form {
    display: inline-grid;
    margin-top: 1em;
    margin-block-end: 2em;
}
.uploadbtn{
    display: inline-grid;

}
.backb{
    margin-top: 35px;
    margin-left: 10px;;
}
.outer{
    margin-top: 30px;
}
.backb {
    background-color: #81C6E8;
            border: none;
            color: white;

            padding: 6px 24px;
            text-decoration: none;
            margin: 6px 2px;
            cursor: pointer;
            border-radius: 10px;
        }
        .backb:hover {
            transform: scale(1.1);
        }
</style>

</head>
<a href="studentAnnouncements.php"><input type="button" class="backb" value="Announcements"></a>
<br>
<?php

session_start();
date_default_timezone_set("Asia/Calcutta");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classroom";



try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "CREATE TABLE  if not exists  assignment_subm (student_email varchar(255),coursecode varchar(255),assignment_id varchar(255),id varchar(255),`name` varchar(255),mime varchar(255),data mediumblob,submittedtime varchar(255)	,gotgrade varchar(10),`status` int(1),submstatus int(1))";

    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "" . $conn->error;
    }

    $conn->close();
} catch (Exception $e) {
    echo "";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studemail = $_SESSION['studentEmail'];
    $conn = new mysqli($servername, $username, $password, $dbname);
    $coursecode = $_SESSION['coursecode'];
    $sql = "SELECT coursename,subject FROM courses WHERE coursecode='$coursecode'";
    $resu = $conn->query($sql);
    $display = $resu->fetch_assoc();
    $subject = $display['subject'];
    $dbh = new PDO("mysql:host=localhost;dbname=classroom", "root", "");

    if (isset($_POST['btn'])) {
        $submission_id = rand(100000, 999999);
        $studemail = $_SESSION['studentEmail'];
        $coursecode = $_SESSION['coursecode'];
        $assignment_id = $_POST['assignment_id'];

        $name = $_FILES['myfile']['name'];
        $type = $_FILES['myfile']['type'];
        $data = file_get_contents($_FILES['myfile']['tmp_name']);
        $submittedtime = date('m/d/Y h:i:s a', time());

        // $stmt = $dbh->prepare("INSERT INTO myblob VALUES ('',?,?,?)");
        $stmt = $dbh->prepare("INSERT INTO assignment_subm (student_email,coursecode,assignment_id,id,name,mime,data,submittedtime,submstatus) VALUES ('$studemail',' $coursecode','$assignment_id','$submission_id',?,?,?,'$submittedtime',1)");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $type);
        $stmt->bindParam(3, $data);
        $stmt->execute();
    }
    $sql2 = "SELECT * FROM postassignment WHERE coursecode='$coursecode' order by postedtime desc";
    $res = $conn->query($sql2);
    if ($res->num_rows > 0) {   //if assignment exsit
        echo "<div class='outer'>";
        while ($row = $res->fetch_assoc()) {  //for each assignment
            echo "<div class='box'>";
            echo "<div class='left'>";
            $task = $row['task'];
            $maxima = $row['maxgrade'];
            $assignment_id = $row['assignment_id'];
            echo "<b>TASK</b> : " . $task . "<nbsp><br>";
            echo "Assigned  : " .  $row['postedtime'] . "<br>";
            echo "Dead Line  : " .  $row['deadline'] . "<br>";
            echo "Maximum Grade : " . $maxima . "<br><br>";

            echo "</div>";


            $conn2 = new mysqli($servername, $username, $password, $dbname);

            $sql29 = "SELECT * FROM assignment_subm WHERE ( assignment_id='$assignment_id' and student_email = '$studemail')";
            $res23 = $conn2->query($sql29);


            if ($res23->num_rows != 0) {
                echo "<div class='right'>";
                //if there is submission
                echo "Assigment Turned In";


                $dbh = new PDO("mysql:host=localhost;dbname=classroom", "root", "");
                $stat = $dbh->prepare("SELECT * FROM  assignment_subm  where (assignment_id = $assignment_id and student_email = '$studemail' )");
                $stat->execute();
                while ($row = $stat->fetch()) {
                    $submittedtime = $row['submittedtime'];
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    $sql100 = "SELECT * FROM postassignment WHERE assignment_id = '$assignment_id'";
                    $res100 = $conn->query($sql100);
                    $res100 = $res100->fetch_assoc();
                    $deadlinetime = $res100['deadline'];
                    if (strtotime($submittedtime) > strtotime($deadlinetime)) {
                        echo "<p>Submitted late</p>";
                    } else {
                        echo "<p>Submitted ontime</p>";
                    }
                    $filenaame = $row['name'];
                    $name = $row['student_email'];
                    if ($row['status'] == 1 && $row['submstatus'] == 1) {
                        $mymarks = $row['gotgrade'];
                        echo "<p style='color:green;'>Graded : $mymarks / $maxima</p>";
                    } else if ($row['status'] == 0 && $row['submstatus'] == 1)
                        echo "<p style='color:red;'>Not Graded</p>";
                    echo  "  <a title = 'Download' target = '_blank' href='view.php?id=" . $row['id'] . "' download= '$filenaame'><br><img class='download' src='download.png'></img> </a> <nbsp>";
                    echo '</div>';
                    break;
                }



                echo '</div>';
            } else

            if ($res23->num_rows == 0) {  //if  not submitted file
                echo "<div class='right'>";

                echo '    <form method="post" action="submitassignment.php" enctype="multipart/form-data" >
                <input type="hidden" name="code" value="0">
        <input type="hidden" name="submstatus" value="1">
        <input type="file" class="custom-file-upload" name="myfile" required />
        <input type="hidden" name="assignment_id" value="' . $assignment_id . '">
        <br>
                      <button name="btn" class="uploadbtn" >Upload</button>
                      <p>Max Size : 100 kB </p>
    </form>';
                echo '</div></div>';
            }
        }
        echo "</div>";
    }
}
?>
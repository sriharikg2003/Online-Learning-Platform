<!-- Set primary key -->

<?php

session_start();
if (!isset($_SESSION['email'])) {
    echo ' <script>
         alert("Unauthorized access. Please Login!");
         window.location = "index.php";
     </script>';
}


?>

<html>
<head>
<style>
    body {
    font-family: sans-serif;
    margin: 0;
    padding: 0;

}
textarea {
    width: 596px;
    height: 132px;
}
.postas {
    margin-left: 1%;
    padding: 31px;
}
.simply {
    margin-left: 2%;
}
.alsosimply {
    margin-left: 2%;
    margin-bottom: -13px;
}
.remind {
    display: inherit;
    margin-left: 90%;
}
.download {
    position: relative;
    right:25px;
    top:11px;
    height: 25px;
    width: 25px;
    margin-bottom: -17px;
}
.bigas {
    border-radius: 5px;
    background-color: #abd9ff;
    margin: 35px;
    padding: 16px 16px 16px 16px;
    display: block;

}
.postprof{

   
    border-radius: 5px;
    background-color: #abd9ff;
    margin: 35px;
    padding: 16px 16px 16px 16px;
    display: block;
        
 
}
.smallas {
    border-radius: 5px;
    background-color: #F7F7F7;
    margin: 18px 42px 2px 30px;
}

.stud {
    padding: 5px 36px 10px;
}

.notify {
    justify-content: center;
    margin: auto;
    margin-top: 0;
    bottom: 0;
    padding: 20px;
    background-color: #E5EBB2;
    justify-content: center;
    width: 200px;
    height: 20px;
    border-radius: 15px;
    text-align: center;
}

.formnotify {
    margin: 0;
    margin-top: 0;

}

.container {
    margin: auto;
    margin-top: 4%;
    padding: 33px;
    background-color: #E5EBB2;
    justify-content: center;
    width: 186px;
    height: 250px;
    border-radius: 19px;
    text-align: center;
}

h2 {
    margin-bottom: auto;
    margin-top: auto;
    text-align: center;
    color: brown;
}

.text {
    margin-top: 20px;
    background-color: #EEEEEE;
    color: #06283D;
    padding: 0.5em;
    border-radius: 10px;
    border-top: 0;
    border-left: 0;
    border-right: 0;
    outline: none;
    text-align: center;
    transition-duration: 0.1s;

}

input.i {
    width: 100%;
}

input[type=text] {
    width: 10%;
    padding: 5px 20px;
    margin: 8px 0;
    box-sizing: border-box;
}

.left {
    display: inline;
    float: left;
}

.right {
    display: inline;
    float: right;
}
.topbtn {
            background-color: #81C6E8;
            border: none;
            color: white;

            padding: 6px 24px;
            text-decoration: none;
            margin-top:25px;
            margin-left: 15px;
            cursor: pointer;
            border-radius: 10px;
        }

        .topbtn:hover {
            transform: scale(1.1);
        }
</style>

</head>
<!-- <form action="professorHome.php">
    <input type='submit' value='home'>
</form> -->
<div class="home">
            <form action="professorHome.php">
                <input class="topbtn" type='submit' value='HOME'>
            </form>

        </div>
</html>
<?php
date_default_timezone_set("Asia/Calcutta");
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['course-code'])) {
        $_SESSION["course-code"] = $_POST['course-code'];
        $_SESSION['courseName'] = $_POST['courseName'];
    }
}
$email = $_SESSION["email"];
$coursecode = $_SESSION["course-code"];
$courseName = $_SESSION['courseName'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classroom";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "CREATE TABLE if not exists assignment_subm(student_email varchar(255),coursecode varchar(255),assignment_id varchar(255),id varchar(255),`name` varchar(255),mime varchar(255),data mediumblob,submittedtime varchar(255)	,gotgrade varchar(10),`status` int(1),submstatus int(1))";

    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "" . $conn->error;
    }

    $conn->close();
} catch (Exception $e) {
    echo "";
}



try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "CREATE TABLE courses if not exists (profemail varchar(255),coursename varchar(255), coursecode varchar(255) PRIMARY KEY)";
    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "" . $conn->error;
    }

    $conn->close();
} catch (Exception $e) {
    echo "";
}
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "CREATE TABLE if not exists postassignment(profemail varchar(255),coursecode varchar(255), assignment_id varchar(255) ,task varchar(255),postedtime varchar(255), deaddate varchar(255),deadtime varchar(255),maxgrade varchar(10))";

    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "" . $conn->error;
    }

    $conn->close();
} catch (Exception $e) {
    echo "";
}
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>


<html>
<h1 class="alsosimply ">Post Assignment</h1>
<div class="postprof">


    <form class="postas" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <b>Task</b><br>
        <textarea rows="3" name="post-assignment" cols="100" placeholder="Post Assignment to your class" required></textarea>
        <input name='coursecode' type='hidden' value='<?php echo $coursecode ?>'>
        <br><br><b>Dead Line</b><br>
        <input type="datetime-local" name="deadline" id="etime" required><br><br>
        <b> Max Marks </b><br> <input type="text" name="maxgrade" required maxlength="4"><br> <br>
        <input type="submit" name="post" value="Post Assignment" required>
    </form>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['grade-btn'])) {

    $gotgrade = $_POST['gotgrade'];
    $fileid = $_POST['fileid'];
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql3 = "UPDATE  assignment_subm SET gotgrade = '$gotgrade' ,`status`=1 where id= $fileid ";
    $res = $conn->query($sql3);
}

?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post-assignment'])) {
    $task = $_POST['post-assignment'];

    $maxgrade = $_POST['maxgrade'];
    $deadline = $_POST['deadline'];
    $postedtime = $date_clicked = date('Y-m-d H:i:s');
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $assignment_id = rand(100000, 999999);
    $sql = "INSERT INTO postassignment (profemail,coursecode,assignment_id,task,postedtime,deadline,maxgrade)
    VALUES ('$email','$coursecode','$assignment_id','$task','$postedtime','$deadline','$maxgrade')";
    if ($conn->query($sql) === TRUE) {
        echo "Assignment Posted successfully";
    }
    $announcement = "Dear Student , New Assignment is Posted in the Assignment Section. <br>Task : " . $task . "<br>Please Check Assignment Section";

    $sql3 = "INSERT INTO announcements(coursecode,date,announce,email) VALUES ('$coursecode','$postedtime','$announcement','$email')";
    $res = $conn->query($sql3);
}
?>
<h1 class='simply'>Previous Assignments</h1>
<?php

$conn = new mysqli($servername, $username, $password, $dbname);
$sql2 = "SELECT * FROM postassignment WHERE coursecode='$coursecode' order by postedtime desc";
$res = $conn->query($sql2);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        // $e = $row['email'];
        $task = $row['task'];
        $assignment_id = $row['assignment_id'];
        echo "<div class='bigas'>";
?>
        <button onclick="myFunction(<?php echo  $assignment_id ?>)">v</button>

<?php
        echo "<b>TASK : </b>" . $task;
        $maxima = $row['maxgrade'];
        echo "<br>Max Grade : " . $maxima;

        echo  "<br>" . $row['postedtime'];
        echo "<form class = 'remind' action='notifyhw.php' method='post'> 
        <input name='coursecode' type='hidden' value='$coursecode'>
        <input name='courseName' type='hidden' value='$courseName'>        
        <input name='assignment_id' type='hidden' value='$assignment_id'>    
        <input name='task' type='hidden' value='$task'>
        <input type='submit' title='Remind Students'  value='Reminder'>
        </form><div id='$assignment_id' class='as' style='display:none'>
        ";

        echo "<ol>";

        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql100 = "SELECT * FROM postassignment WHERE assignment_id = '$assignment_id'";
        $res100 = $conn->query($sql100);
        $res100 = $res100->fetch_assoc();
        $deadlinetime = $res100['deadline'];
        $dbh = new PDO("mysql:host=localhost;dbname=classroom", "root", "");
        $stat = $dbh->prepare("SELECT * FROM  assignment_subm  where assignment_id = $assignment_id");
        $stat->execute();
        while ($row = $stat->fetch()) {
            echo "<div class='smallas'>";
            $submittedtime = $row['submittedtime'];
            $filenaame = $row['name'];
            $name = $row['student_email'];
            echo "<div class='stud'><li>" . $row['student_email'] . " <div class='right'> <a target = '_blank' href='view.php?id=" . $row['id'] . "' download= '$filenaame'><img class='download' src='download.png'></a> <nbsp><br>" . $submittedtime . "</li>";
            if (strtotime($submittedtime) > strtotime($deadlinetime)) {
                echo "<p style='color: red'>Submitted late</p>";
            } else {
                echo "<p  style='color: green'>Submitted ontime</p>";
            }
            if ($row['status'] == 0) {
                echo "Assign Marks : <form action = 'Assignment.php' method ='post'> <input type = 'text' name = 'gotgrade'> <input type = 'hidden' name ='fileid' value='" . $row['id'] . "'><input type = 'submit' name='grade-btn' value='Assign'></form> ";
            } else echo "Graded : " . $row['gotgrade'] . " / $maxima";

            echo "</div></div>";
        }
        echo "</ol></div>";

        echo "</div>
        ";
    }
}
?>

</html>


<script>
    function myFunction(y) {

        var x = document.getElementById(y);
        <?php echo $assignment_id ?>

        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>

</html>
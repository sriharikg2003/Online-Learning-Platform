<?php
session_start();

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classroom";

try{
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql ="CREATE TABLE submittedtest (
        student_email varchar(255),
        test_id INT,
        questionid INT,
        correct_answer INT,
        student_answer INT,
        score INT )";
    $conn->query($sql);
    $conn->close();
}
catch(Exception $e){
echo ""; 
}

try{
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql ="CREATE TABLE marksheet (
        stu_email varchar(255),
        marks_obtained INT,
        test_id INT )";
    $conn->query($sql);
    $conn->close();
}
catch(Exception $e){
echo ""; 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .que{
            display: flex;
            height:90vh;
            
            justify-content: center;
            align-items: center;
        }
        .inner{
            background-color:#Dde2dd;
            text-align:center;
            width:450px;
            padding:10px;
            border: 2px solid #00203FFF;
            border-radius: 5px;
        }
        .next{
            float:right;
        }
        .endtest{
            float:left;
        }
        .head{
            color:blue;
        }
        .nx{
            background-color:white;
        }
    </style>
</head>
<body>
<form action="testPage.php" method="post">
<?php

date_default_timezone_set("Asia/Calcutta");
// if(isset($_POST['dummy'])){
//     $_SESSION["test_id"]=$_POST["test_id"];
// }

if(isset($_POST['return'])){
    header("Location:studentAnnouncements.php");
}

if(isset($_POST['dummy'])){
    $_SESSION["test_id"]=$_POST["test_id"];
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {

// $_SESSION["test_id"]=$_POST["test_id"];
// if(!isset($_POST['endTest'])){
$test_id=$_SESSION["test_id"];
$qno=$_SESSION["qno"];
// }
// $email=$_SESSION["email"];

$student_email = $_SESSION["studentEmail"];


$conn = new mysqli($servername, $username, $password, $dbname);
$sql="SELECT * FROM marksheet WHERE test_id = '$test_id' AND stu_email ='$student_email'";
$result = $conn->query($sql);

if($result->num_rows > 0){
    echo"<h4>You have already attempted</h4><br>";
    echo "<button><a href='stHome.php'>Back</a></button>";
}else{

    

$conn = new mysqli($servername, $username, $password, $dbname);

$sql="SELECT * FROM test_question WHERE test_id = '$test_id' AND qno='$qno'";
$result = $conn->query($sql);
if( $result->num_rows>0){
        $k= date("Y-m-d H:i:s"); 
        // echo "$k";
        // echo"<br>"; 
        $sql1="SELECT * FROM tests WHERE id = '$test_id'";
        $result1 = $conn->query($sql1);
        $row1=$result1->fetch_assoc();
        $endtime=$row1["endTime"];
        // echo "$endtime";
        if($endtime<$k){
            echo "<h3>The Test has ended</h3><br><br>";
            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql7="SELECT SUM(score) AS total FROM submittedtest WHERE test_id='$test_id' and score='1' and student_email='$student_email' GROUP BY student_email ";
            $res=$conn->query($sql7);
            $row = $res->fetch_assoc();
            $result1 = $row['total'];
            // echo $result;
            // $sql8="INSERT INTO marksheet ('student_email', 'marks_obtained','test_id') 
            // values ('$student_email','$result','$test_id')";
            $sql8 = "INSERT INTO `marksheet`  VALUES ('$student_email', '$result1', '$test_id')";
            $res4=$conn->query($sql8);
            $conn->close();
            echo "<input type='submit' name='return' value='Return' class='Return'";
            // header("Location:studentAnnouncements.php");
        }else{
        $row =$result->fetch_assoc();
        $question=$row["question"];
        $questionid=$row["questionid"];
        $qn=$_SESSION['qno'];
        echo "
        <div class='que'>
        <div class='inner'>
        <h4 class='head'>Question No. $qn</h4>
        <h5>$question</h5>      
        <input type ='text' name='student_answer'>
        <input type='hidden' name='questionid' value='$questionid'>
        <input type='submit' name='inTest' value='Next' class='next'>
        </div>
        </div>
        ";
        $_SESSION['qno']+=1;
        }
}else{
    echo "<h4>Do you want to end Test?</h4>";
    echo "<input type='submit' name='endTest' value='endTest' class='endtest'";
}

if(isset($_POST['inTest'])){
    // $k= date("Y-m-d H:i:s");
    // echo "$k"; 
    // echo "<br>";
    // $sql1="SELECT * FROM tests WHERE id = '$test_id'";
    // $result1 = $conn->query($sql1);
    // $row1=$result1->fetch_assoc();
    // $endtime=$row1["endTime"];
    // echo"$endtime";
        // if($endtime<$k){
            // echo "<h3>The Test has ended</h3><br><br>";
            // echo "<h4>Do you want to end Test?</h4><br><br>";
            // echo "<input type='submit' name='endTest' value='endTest' class='endtest'";
        // }else{

        $questionid = $_POST["questionid"];
        $student_answer = $_POST["student_answer"];

        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql3="SELECT answers FROM test_question WHERE test_id ='$test_id' and questionid ='$questionid'";
        $res= $conn->query($sql3);
        $row = $res->fetch_assoc();
        $answer = $row['answers'];
        $conn->close();

        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql="INSERT INTO submittedtest(student_email, test_id, questionid, student_answer,score,correct_answer) 
        VALUES ('$student_email', '$test_id', '$questionid', '$student_answer',0,'$answer')"; 
        $res =$conn->query($sql);
        $conn->close();    
    
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql5="UPDATE submittedtest SET score = 1 
        where test_id = '$test_id' and questionid='$questionid' and student_answer = correct_answer";
        $res=$conn->query($sql5);
        $conn->close();
        }
    }
    echo "<input type='submit' name='inTest' value='' class='nx'>";

    if(isset($_POST['endTest'])){
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql7="SELECT SUM(score) AS total FROM submittedtest WHERE test_id='$test_id' and score='1' and student_email='$student_email' GROUP BY student_email ";
        $res=$conn->query($sql7);
        $row = $res->fetch_assoc();
        $result1 = $row['total'];
        // echo $result1;
        // $sql8="INSERT INTO marksheet ('student_email', 'marks_obtained','test_id') 
        // values ('$student_email','$result','$test_id')";
        $sql8 = "INSERT INTO `marksheet`  VALUES ('$student_email', '$result1', '$test_id')";
        $res4=$conn->query($sql8);
        $conn->close();
        echo "<br><br>";  
        echo "<input type='submit' name='return' value='Return to Home'>";
    }
    

// }
}
?>
</form>

</body>
</html>
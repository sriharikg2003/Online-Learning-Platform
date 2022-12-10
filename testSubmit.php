<?php
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


if($_SERVER['REQUEST_METHOD']=='POST'){
    $student_email = $_POST["student_email"];
    $test_id = $_POST["test_id"];
    $questionid = $_POST["questionid"];
    $student_answer = $_POST["student_answer"];

    //REQUIRED CODE 
    // $student_email = $_SESSION["student_email"];
    // $test_id = $_SESSION["test_id"];
    // $questionid = $_SESSION["questionid"];
    // $student_answer = $_SESSION["student_answer"];


    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql3="SELECT answer FROM test_question WHERE testId ='$test_id' and questionid ='$questionid'";
    $res= $conn->query($sql3);
    $row = $res->fetch_assoc();
    $answer = $row['answer'];
    // $sql2="INSERT INTO submittedtest (correct_answer) VALUES ('$result')";
    // $res1=$conn->query($sql2);
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

    // $conn = new mysqli($servername, $username, $password, $dbname);
    // $sql6="UPDATE submittedtest set score = 0 where test_id = '$test_id' and questionid = '$questionid'";
    // $res=$conn->query($sql6);
    // $conn->close();

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
}
?>
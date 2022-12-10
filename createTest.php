<?php 
//Creator->Mandar
$servername="localhost";
$username="root";
$password="";
$dbname="classroom";

session_start();
if(isset($_POST["crea"])){
    $a = $_SESSION['test-name'] = $_POST['test-name'];
    $b = $_SESSION['test-start-time'] = $_POST['test-start-time'];
    $c = $_SESSION['test-end-time'] = $_POST['test-end-time'];
    $d = $_SESSION['no-of-ques'] = $_POST['no-of-ques'];
    $_SESSION["qno"]=1;
    $test_id = rand(1,1000000);
    $_SESSION['test_id'] = $test_id;
    $coursecode = $_SESSION['coursecode'];
    $conn = new mysqli($servername, $username, $password, $dbname);
    $prof_email = $_SESSION['email'];
    // echo $coursecode;
    $sql = "INSERT INTO tests(id,testName,startTime,endTime,profEmail,coursecode) VALUES('$test_id','$a','$b','$c','$prof_email','$coursecode');";
    $conn->query($sql);
    $conn->close();
    header("Location:createQues.php");
    // header("Location:creTest.php");
}else if(isset($_POST["back"])){
    header("Location:profAnnouncements.php");
}


if(isset($_POST["back"])){
    header("Location:profAnnouncements.php");
}


?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body{
            display: flex;
            height:90vh;
            justify-content: center;
            align-items: center;    
        }
        .head{
            text-align:center;
            color:darkblue;
        }
        .cre{
            border:3px solid #00203FFF;
            padding-bottom:20px;
            padding-right:20px;
            padding-left:20px;
            height:290px;
            background-color:#Dde2dd;
            margin:10px;
            border-radius:5px;
        }
        .label{
            float:left;
        }
        .input{
            position: relative;
             display: block;
             margin : 0 auto;
        }
        .sub{
            background-color:white;
            border: 1.5px solid black;
            border-radius:5px;
            padding:2.5px;
        }
        .back{
            border: 1.5px solid black;
            border-radius:5px;
            padding:3px;
            background-color:white;
        }
        .btn{
            text-align:center;
        }
        .right{
            text-align:center;
        }
    </style>
</head>
<body>
    <div class='cre'>
            <h2 class='head'>Create Test</h2>
            <form method="post" action="createTest.php">
                <div class="indi">
                <label for="testName">Test Name: </label>
                <input type="text" id="testName" placeholder="Enter the name of test" name="test-name" required><br><br>
                </div>
                <label for="stime">Enter Test Start time: </label>
                <input type="datetime-local" id="stime" name="test-start-time" required><br><br>
                <label for="etime">Enter Test End time: </label>
                <input type="datetime-local" name="test-end-time" id="etime" required><br><br>
                <label for="ques">Enter Number of Questions: </label>
                <input type="number" id="ques" name="no-of-ques" placeholder="Number of Questions" required>
                <br><br>
                <div class='right'>
                <input type="submit" value="Create Test" name="crea" class='sub'> 
                </div>
            </form>
            <br>
            <div class='btn'>
            <form method="post" action="createTest.php">
                <input type="submit" value="Back" name="back" class='back'>
            </form>
            <div>
    </div>

</body>
</html>
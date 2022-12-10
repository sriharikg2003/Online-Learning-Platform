<?php 
//Creator->Mandar
session_start();
$servername="localhost";
$username="root";
$password="";
$dbname="classroom";

try{
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql ="CREATE TABLE test_question (
                test_id INT,
                question varchar(255),
                questionid INT,
                answers varchar(255),
                queno INT
                )";
    $conn->query($sql);
    $conn->close();
}
catch(Exception $e){
echo ""; 
}


// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $test_id=$_SESSION["test_id"];
//     $question=$_POST["question"];
//     $answers=$_POST["answers"];
//     $questionid = rand(1,100000000000);
//     $conn = new mysqli($servername, $username, $password, $dbname);
//     $sql = "INSERT INTO test_question (test_id,question,questionid,answers) VALUES ('$test_id', '$question','$questionid', '$answers')";
//     $conn->query($sql);
//     $conn->close();
// }




if($_SERVER['REQUEST_METHOD']=='POST'){
    $submit = $_POST['x'];
    if($submit=='Back'){
        header("Location:createTest.php");
    }
    else{
        $test_id = $_SESSION['test_id'];
        $conn = new mysqli($servername, $username, $password, $dbname);
        for($x = 1; $x<=$_SESSION['no-of-ques'];$x++){
            $z = $x+$_SESSION['no-of-ques'];
            $question = $_POST[$x];
            $answers = $_POST[$z];
            $questionid = rand(1,10000000);
            $sql = "INSERT INTO test_question (test_id,question,questionid,answers,qno) VALUES ('$test_id', '$question','$questionid', '$answers','$x')";
            $conn->query($sql);
        }
        $conn->close();
        header("Location:TestNotification.php");
    }
}
?>
<!DOCTYPE html>
<html >
<head>
    <title>IIT Dharwad Classroom</title>
    <style>
        body{
        text-align: center;
        }
    </style>
</head>
<body>
    <h1><?php echo  $_SESSION['test-name'];?></h1>
    <form action='createQues.php' method='post'>
    <?php 
    for($i=1;$i<=$_SESSION['no-of-ques'];$i++){
        $j = $i +$_SESSION['no-of-ques'];
        echo "<label for='que'>Question $i</label>";
        echo "<textarea cols='30' rows='4' name='$i' id='que' required></textarea><br>";
        echo "<label for='sol'>Answer $i</label>";
        echo "<input type='number' id='sol' name='$j' placeholder='integer answer' required><br><br>";
    }
    ?>
    <input type="submit" value="Create-Test" name='x'>
    <input type='submit' value='Back' name='x'>
    </form>
</body>
</html>
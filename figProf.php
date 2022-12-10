
<!DOCTYPE html>
<html>
<body>
    <?php
    session_start();
    // echo "Hello";
    // $_SESSION["test_id"] = 376337;
    // $_SESSION["prof_email"] = "bcd@gmail.com";
    if(isset($_POST['Result'])){
        $testid = $_POST["test_id"];
        $_SESSION["test_id"]=$testid;
    }
   


    $testid = $_SESSION["test_id"];
    // $studentemail = $_SESSION["prof_email"];
    // echo $testid;
    $servername = "localhost"; 
    $username = "root";
    $password = "";
    $dbname = "classroom";

    // try{
    //     $conn = new mysqli($servername, $username, $password,$dbname);
    //     $sql = "CREATE TABLE graph (id int AUTO_INCREMENT, testid int(11),student_email varchar(255))";
    //     $conn->query($sql);
    //     $conn->close();
    // }
    // catch(Exception $e){
    //     echo "";
    // }

    // $conn = new mysqli($servername, $username, $password,$dbname);
    // $sql2 = "INSERT INTO graph (testid,student_email) VALUES ('$testid', '$studentemail')";
    // $conn->query($sql2);
    // $conn->close();
    // echo "hello";

    $conn = new mysqli($servername, $username, $password,$dbname);
    $sql = "select stu_email, marks_obtained from marksheet where test_id='$testid'";
    $res= $conn->query($sql);
    $mail="";
    $marks="";
    while($s = $res->fetch_assoc()){
        $mail = $mail.$s['stu_email'].",";
        $marks = $marks.$s['marks_obtained'].",";
    } 
    // echo $mail."<br>";
    // echo $marks;
    $sql2 = "SELECT MAX(marks_obtained) as maxmarks, MIN(marks_obtained) as minmarks, AVG(marks_obtained) as avgmarks FROM marksheet WHERE test_id='$testid'";
    $res = $conn->query($sql2);
    $mma = $res->fetch_assoc();
    $max = $mma['maxmarks'];
    $min = $mma['minmarks'];
    $avg = $mma['avgmarks'];
    
    $ques="";
    $scores="";
    $sql3 = "SELECT DISTINCT(questionid) FROM submittedtest where test_id='$testid'";
    $res = $conn->query($sql3);
    while ($q = $res->fetch_assoc()){
        $q = $q['questionid'];
        $sql4 = "SELECT SUM(score) as score FROM submittedtest WHERE test_id='$testid' AND questionid='$q'";
        $res2 = $conn->query($sql4);
        $sc = $res2->fetch_assoc();
        $sc = $sc['score'];
        $ques=$ques.$q.",";
        $scores=$scores.$sc.",";
    } 
    // echo $ques;
    // echo $scores;

    echo shell_exec("python proffig.py $mail $marks $max $min $avg $ques $scores");

    $conn->close();

    ?>
    <form action="profAnnouncements.php" method="post">
        <input type="submit" value="Back">
</form>
</body>
</html>


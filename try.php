
<!DOCTYPE html>
<html>
<body>

<form action="studentTest.php" method="post">
        <input type="submit" value="Back">
</form>
    <?php
    session_start();
    // echo "Hello";
    // $_SESSION["test_id"] = 12345;
    // $_SESSION["student_email"] = "bcd@gmail.com";
    $testid = $_POST["test_id"];
    $studentemail = $_SESSION["studentEmail"];
    // echo $testid;
    // echo "<br>";
    // echo $studentemail;
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
    $sql = "select marks_obtained from marksheet where stu_email='$studentemail' and test_id='$testid'";
    $res= $conn->query($sql);
    $val1 = $res->fetch_assoc();
    $val = $val1["marks_obtained"];
    $sql2 = "select MAX(marks_obtained) as max, AVG(marks_obtained) as avg from marksheet where test_id='$testid'";
    $res= $conn->query($sql2);
    $stat = $res->fetch_assoc();
    $stat1 = $stat["max"];
    $stat2 = $stat["avg"];

    // echo $val;
    // echo"<br>";
    // echo $stat1;
    // echo"<br>";
    // echo $stat2;
    $sql3 = "SELECT marks_obtained from marksheet where stu_email='$studentemail' and test_id='$testid'";
    $res= $conn->query($sql3);
    $myscore1 = $res->fetch_assoc();
    $myscore = $myscore1['marks_obtained'];
    // echo $stat;
    $sql4 = "SELECT COUNT(*) as total FROM submittedtest where test_id='$testid' and student_email='$studentemail'";
    $res= $conn->query($sql4);
    $total = $res->fetch_assoc();
    $total = $total['total'];
    $wrong = $total - $myscore;
    // echo $wrong;
    // echo $stat;
    $sql5 = "SELECT questionid from submittedtest where test_id='$testid' and student_email='$studentemail'";
    $res = $conn->query($sql5);
    $ques="";
    while($q = $res->fetch_assoc()){
        // echo "hello";
        // $ques=$ques+array($q);
        $q = $q['questionid'];
        // echo $q;
        // $ques=$ques+array($q);
        // array_push($ques,$q);
        $ques = $ques.$q.",";
    }
    $sql6 = "SELECT score from submittedtest where test_id='$testid' and student_email='$studentemail'";
    $res= $conn->query($sql6);
    $score="";
    while($s = $res->fetch_assoc()){
        $s = $s['score'];
        $score=$score.$s.","; 
    }  
    // echo $ques;
    // echo $score; 
    // echo $ques[1];

    // $ques = $ques['questionid'];
    // echo $ques[1];
    // foreach ($ques as $value) {
    //     echo "$value <br>";
    //   }

    echo shell_exec("python fig.py $val $stat1 $stat2 $myscore $wrong $ques $score");
    $conn->close();
    ?>
</body>
</html>


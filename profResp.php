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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
    <form id='view_form' method='post' action='profResp.php'>
    <input type='submit' name='back' title='Back' class='' value='Back'>
    </form>
<br>

<table>
    
<?php

if(isset($_POST["back"])){
    header("Location:profAnnouncements.php");
}
if(isset($_SESSION["test_id"])){

}
if(isset($_POST["submit"])){
    $_SESSION["stu_email"]=$_POST["name"];
    $_SESSION["feed"]=$_POST["feed"];
    $_SESSION["test_id"] = $_POST["test_id"];
    header("Location:feedbackMail.php");
}

if(isset($_POST['resp'])){
    $test_id=$_POST["test_id"];
$_SESSION['test_id']=$_POST["test_id"];
}


$test_id = $_SESSION['test_id'];
// echo $_POST['test_id'];
$conn = new mysqli($servername, $username, $password, $dbname);

$sql="SELECT * FROM marksheet WHERE test_id = '$test_id'";
$result = $conn->query($sql);


if( $result->num_rows>0){
    echo"
    <tr>
    <th>Student Email</th>
    <th>Student Name</th>
    <th>Marks Obtained</th>
    </tr>
    ";
    while($row = $result->fetch_assoc()){
        $stu_email=$row["stu_email"];
        $marks=$row["marks_obtained"];

        $sql1="SELECT * FROM students WHERE email = '$stu_email'";
        $result1 = $conn->query($sql1);
        if( $result1->num_rows>0){
            $row1 = $result1->fetch_assoc();
            $fname=$row1["firstname"];
            $lname=$row1["lastname"];
            $name=$fname.' '.$lname;
            echo "
            <tr>
                <td>$stu_email</td>
                <td>$name</td>
                <td>$marks</td>
            </tr>
            ";
        }
    }
}else{
    echo"You have no responses yet";
    echo"
    <form id='view_form' method='post' action='profResp.php'>
    <input type='submit' name='back' title='Back' class='' value='Back'>
    </form>"
    ;
}





echo "
<h4>Feedback for Student</h4>
    <form id='view_form' method='post' action='profResp.php'>
    <label for='name'>Student Email</label>
    <input type='text' id ='name' name='name'  class=''>
    <br><br>
    <label for='feed'>Feedback</label>
    <br>
    <textarea id='feed' name='feed' rows='4' cols='50'>
    </textarea>
    <br><br>
    <input type='hidden' name='test_id' value ='$test_id'>
    <input type='submit' name='submit'>
    </form>
    <br>
    <br>
";

    ?>
</table>
</body>
</html>
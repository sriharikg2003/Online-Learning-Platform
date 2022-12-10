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
    <style>
        .one{
            display: flex;
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
        .head{
            color:blue;
        }
    </style>
</head>
<body>



<?php


echo"
    <form id='view_form' method='post' action='showques.php'>
    <input type='submit' name='back' title='Back' class='' value='Back'>
    </form>"
    ;


if(isset($_POST["back"])){
    header("Location:profAnnouncements.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$test_id=$_POST["test_id"];

$conn = new mysqli($servername, $username, $password, $dbname);

$sql="SELECT * FROM test_question WHERE test_id = '$test_id'";
$result = $conn->query($sql);
if( $result->num_rows>0){
    while($row = $result->fetch_assoc()){
        $question=$row["question"];
        $answer=$row["answers"];
        echo "
        <div class='one'>
        <div class='inner'>
        <h4>Question:</h4> 
        <h5> $question</h5>  
        <h4>Answer:</h4> 
        <h5> $answer</h5>
        </div>
        </div>
        <br><br>
        ";
    }
}else{
    echo"
    <form id='view_form' method='post' action='showques.php'>
    <input type='submit' name='back' title='Back' class='' value='Back'>
    </form>"
    ;
}


}
?>


</body>
</html>
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
            width:300px;
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
<h2 class="head">CHANGE PASSWORD</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

    
    <label for="password" class="label">Old Password:</label>
    <input type="password" name="opassword" class="input">
    <br><br>
    <label for="password" class="label">New Password:</label>
    <input type="password" name="npassword" class="input">
    <br><br>
    <label for="conpassword" class="label">Confirm Password:</label>
    <input type="password" name="conpassword" class="input">
    <br><br>
    <div class="right">
    <input class="sub" type="submit" name="click" value="Change Password">
    <?php if(isset($_POST['click'])){echo"<button class='sub'><a href='professorHome.php'>Home</a></button>";} ?>
<div>
    <?php 
session_start();
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if(isset($_POST['click'])){

$opass=test_input($_POST["opassword"]);
$npass=test_input($_POST["npassword"]);
$conpass=test_input($_POST["conpassword"]);
$email=$_SESSION['email'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classroom";

$upd=0;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


if($npass!=$conpass){
    echo"<h5>Both Passwords don't match.</h5>";
}else if($npass==$conpass){


        $sql1="SELECT password FROM professors WHERE email='$email' and password='$opass'";
        $res=$conn->query($sql1);
        // $conn->close();
        if($res->num_rows==0){
            echo"<h5>You have entered Incorrect Old Password</h5>";
        }else{
            $sql4="UPDATE professors SET password ='$npass' WHERE email='$email'";
            $res=$conn->query($sql4);
            $upd=1;
            echo"<h5>Password Changed Successfully</h5>";
            // header("Location: professorHome.php");
        }





    // }else if($usertype=="student"){
    //     $sql2="SELECT email FROM students WHERE email='$email'";
    //     $res=$conn->query($sql2);
    //     if($res->num_rows==0){
    //         echo"";
    //     }else{
    //         $sql3="UPDATE students SET password ='$pass' WHERE email='$email'";
    //         $res=$conn->query($sql3);
    //         $upd=1;
    //         // header("Location: indexLogin.php");
    //     }
    }
    $conn->close();
}
    

?>




</div>
    

</form>
<br>
</div>



</body>
</html>

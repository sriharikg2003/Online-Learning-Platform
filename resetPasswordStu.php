<!DOCTYPE html>
<html>
    <!-- <head>
    <link rel="stylesheet" href="styleproflogin.css">
    </head> -->
<body>

<?php 
session_start();
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

$pass=test_input($_POST["password"]);
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


if($pass!=$conpass){
    echo"Both Passwords don't match.";
}else if($pass==$conpass){
        $sql2="SELECT email FROM students WHERE email='$email'";
        $res=$conn->query($sql2);
        if($res->num_rows==0){
            echo"";
        }else{
            $sql3="UPDATE students SET password ='$pass' WHERE email='$email'";
            $res=$conn->query($sql3);
            $upd=1;
        }
    }
    $conn->close();
}

?>

<div class="loginfrm">
<form method="post" class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<h2 class="title">RESET PASSWORD</h2>
    <div class="ind">
    <input type="password" name="password" class="input">
    <label for="password" class="label">Password:</label>
    </div>
    <div class="ind">
    <input type="password" name="conpassword" class="input">
    <label for="conpassword" class="label">Confirm Password:</label>
    </div>
    <div class="butn">
    <input class="btn" type="submit" name="click" value="Reset Password">
    <?php if(isset($_POST['click'])){echo"<button><a href='index.php'>Login</a></button>";} ?>
    </div>
    

</form>
<br>
</div>



</body>
</html>

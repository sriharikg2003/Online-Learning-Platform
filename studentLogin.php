<!DOCTYPE html>
<html>
<head> 
    <link rel="stylesheet" href="indexLogin.css">
    </head>
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
$_SESSION["studentEmail"]=test_input($_POST["email"]);
$_SESSION["studentPassword"]=test_input($_POST["password"]);
$Semail = $_SESSION["studentEmail"];
$Spass = $_SESSION["studentPassword"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classroom";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql2="SELECT email FROM students WHERE email='$Semail'";
$res=$conn->query($sql2);
$conn->close();
if($res->num_rows==0){
    echo "Account does not exist!";
}
else{
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql3="SELECT email FROM students WHERE email='$Semail' and `password`='$Spass'";
    $result=$conn->query($sql3);
    if($result->num_rows==0){
        echo "Incorrect Credentials!";
    }
    else{
        header("Location:stHome.php");
    }
}
}

?>

<div class="loginfrm">
<form method="post" class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <h1 class="title">LOGIN PAGE</h1>
    <div class="ind">
    <label for="email" class="label">Email:</label>
    <input type="text" name="email" class="input">
    </div>
    <div class="forpass">
    <a href="verificationStu.php">Forgot Password?</a>
    </div>
    <br><br>
    <div class="ind">
    <label for="password" class="label">Password:</label>
    <input type="password" name="password" class="input">
    </div>  
    <div class="link">
    <a href="studentSignup.php">Don't have an account? Click here to Sign Up.</a>
    </div>
    <div class=butn>
    <input type="submit" class="btn">
    </div>
</form>
<br>
</div>





<!-- <h1>LOGIN PAGE</h1><br>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Email:
    <input type="text" name="email">
    <br><br>
    Password:
    <input type="password" name="password">
    <br><br>
    <input type="submit">
</form>
<br>

<a href="studentSignup.php">Don't have an account? Click here to Sign Up.</a>
 -->

</body>
</html>
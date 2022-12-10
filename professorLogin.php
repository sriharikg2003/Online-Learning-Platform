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
$_SESSION["email"]=test_input($_POST["email"]);
$_SESSION["password"]=test_input($_POST["password"]);
$email = $_SESSION["email"];
$pass = $_SESSION["password"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classroom";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql2="SELECT email FROM professors WHERE email='$email'";
$res=$conn->query($sql2);
$conn->close();
if($res->num_rows==0){
    echo "Account does not exist!";
}
else{
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql3="SELECT email FROM professors WHERE email='$email' and `password`='$pass'";
    $result=$conn->query($sql3);
    if($result->num_rows==0){
        echo "Incorrect Credentials!";
    }
    else{
        header("Location:professorHome.php");
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
    <a href="verification.php">Forgot Password?</a>
    </div>
    <br><br>
    <div class="ind">
    <label for="password" class="label">Password:</label>
    <input type="password" name="password" class="input">
    </div>  
<div class="link">
    <a href="professorSignup.php">Don't have an account? Click here to Sign Up.</a>
</div>
    <div class=butn>
    <input type="submit" class="btn">
    </div>
</form>
<br>
</div>
</body>
</html>
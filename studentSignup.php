<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="indexSignup.css">
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
    $_SESSION["studentFirstname"]=test_input($_POST["firstname"]);
    $_SESSION["studentLastname"]=test_input($_POST["lastname"]);
    $_SESSION["studentEmail"]=test_input($_POST["email"]);
    $_SESSION["studentPassword"]=test_input($_POST["password"]);
    $sfirst = $_SESSION["studentFirstname"];
    $slast = $_SESSION["studentLastname"];
    $semail = $_SESSION["studentEmail"];
    $spass = $_SESSION["studentPassword"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "classroom";


    try{
        $conn = new mysqli($servername, $username, $password);
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
        $sql = "CREATE DATABASE IF NOT EXISTS classroom ";
        $conn->query($sql);
        $conn->close();
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "CREATE TABLE students (firstname varchar(255),lastname varchar(255), email varchar(255), `password` varchar(255))";
        $conn->query($sql);
        $conn->close();
    }
    catch(Exception $e){
    echo "";
    }

    
    if(isset($_POST['click'])){
        $date_clicked = date('Y-m-d H:i:s');
       // echo "Time the button was clicked: " . $date_clicked . "<br>";
        $_SESSION['date_clicked'] = $date_clicked;
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql2="SELECT email FROM students WHERE email='$semail'";
        $res=$conn->query($sql2);
        if($res->num_rows>0){
            echo "user with this email already exists!";
            echo "<a href='studentLogin.php'>Click here to go to Login</a>";
        }
        else{
        header("Location: mailOtpStudent.php");
        }
        $conn->close();
    }
}
?>

<div class="signupfrm">
<form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <h2 class="title">SIGNUP PAGE</h2>
    <div class="ind">
    <input type="text" name="firstname" class="input">
    <label for="firstname" class="label">First Name:</label>
    </div>
    <div class="ind">
    <input type="text" name="lastname" class="input">
    <label for="lastname" class="label">Last Name:</label>
    </div>
    <div class="ind">
    <input type="text" name="email" class="input">
    <label for="email" class="label">Email:</label>
    </div>
    <div class="ind">
    <input type="password" name="password" class="input">
    <label for="password" class="label">Password:</label>
    </div>
    <div class="butn">
    <input class="btn" type="submit" name="click" value="Sign-Up">
    </div>
</form>

</body>
</html>

<!DOCTYPE html>
<html>
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
    $_SESSION["otp"]=test_input($_POST["otp"]);
    $otp=$_SESSION["otp"];
    $time= $_SESSION['date_clicked'];
    $otp_sent=$_SESSION["otp_sent"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "classroom";

    // $first = $_SESSION["firstname"];
    // $last = $_SESSION["lastname"];
    $email = $_SESSION["email"];
    // $pass = $_SESSION["password"];

    if(isset($_POST['check'])){
        $time_clicked = date('Y-m-d H:i:s');
        $_SESSION['time_clicked'] = $time_clicked;
        //header("Location:otpProfessor.php");
    }
    $time_start=strtotime($time);
    $time_end=strtotime($time_clicked);
    if($time_end-$time_start<600 && $otp==$otp_sent){
        header("Location:resetPassword.php");
    }
    else if($time_end-$time_start>600){
        echo "Session Expired";
        echo "<form action='mailForgotOtp.php'>
        <input type='submit' value='Resend OTP'>
        </form>";
    }
    else{
        echo "WRONG OTP!";
    }
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <input type="text" name="otp" placeholder="Enter 6 digit OTP">
    <input type="submit" name="check">
</form>
</body>
</html>

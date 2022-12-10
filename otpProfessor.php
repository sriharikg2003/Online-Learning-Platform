<!DOCTYPE html>
<html>

<head>
<style>
    body {
    font-family: sans-serif;
    
    margin: 0;
    padding: 0;


}


.container {
    margin: auto;
    margin-top: 10%;
    padding: 20px;
    /* background-color: #5C2E7E; */
    background-color: #ABD9FF;
    justify-content: center;
    width: 200px;
    height: 250px;
    border-radius: 15px;
    text-align: center;

}



h2 {
    margin-bottom: 10px;
    text-align: center;
    color:orange;


}


.message {
    margin: 0;
    font-size: 12px;
    color: white;
    margin-bottom: 30px;

}

.textarea {
    margin-top: 20px;
    background-color: #EEEEEE;
    color: #06283D;
    padding: 0.5em;
    border-radius: 10px;
    border-top: 0;
    border-left: 0;
    border-right: 0;
    outline: none;
    text-align: center;
    transition-duration: 0.1s;

}

.textarea:hover {
    background-color: white;
    color: black;
}

.button {
    background-color:white;
    color: black;
    margin-top: 5px;
    border-radius: 5px;
    padding: 5px;
    transition-duration: 0.1s;
    cursor: pointer;
    border-top: 0;
    border-left: 0;
    border-right: 0;
    outline: none;

}

.button:hover {
    background-color: #8D9EFF;
    color: white;
}

.alert{
    margin-top: 20px;
    color: white;
    font-size: small;
}

.wrong-otp{
    text-align: center;
    margin-top: 30px;
    margin-bottom: 0%;
}

.already-exists
{
    color: pink;
    margin-top: 30px;
    text-align: center;
    margin-bottom: -40px;
}

a{
    color: pink;
}
</style>
</head>

<body >
<?php
session_start();
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["otp"] = test_input($_POST["otp"]);
    $otp = $_SESSION["otp"];
    $time = $_SESSION['date_clicked'];
    $otp_sent = $_SESSION["otp_sent"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "classroom";

    $first = $_SESSION["firstname"];
    $last = $_SESSION["lastname"];
    $email = $_SESSION["email"];
    $pass = $_SESSION["password"];

    if (isset($_POST['check'])) {
        $time_clicked = date('Y-m-d H:i:s');
        $_SESSION['time_clicked'] = $time_clicked;
        //header("Location:otpProfessor.php");
    }
    $time_start = strtotime($time);
    $time_end = strtotime($time_clicked);
    if ($time_end - $time_start < 600 && $otp == $otp_sent) {
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "INSERT INTO professors (firstname,lastname,email,`password`)
            VALUES ('$first','$last','$email','$pass')";
        $conn->query($sql);
        $conn->close();
        header("Location:professorHome.php");
    } else if ($time_end - $time_start > 600) {
        echo "Session Expired";
        echo "<form action='mailOtpProfessor.php'>
        <input type='submit' value='Resend OTP'>
        </form>";
    } else {
        echo "<div class='wrong-otp'>Wrong OTP <br>Enter the Correct OTP Again </div>";
    }
}
?>

 <div class=" container">
    <h2>OTP VALIDATION</h2>
    <div class="message">
        Check your mail for OTP
      
    </div>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="par">
            <input type="text" name="otp" placeholder="Enter 6 digit OTP" class="textarea" maxlength="6">
            <br>

            <p style="color:white"> OTP VALID FOR 10 Minutes</p>
            <input type="submit" name="check" class="button" value="VERIFY">
        </div>
    </form>
    </div>

</body>

</html>

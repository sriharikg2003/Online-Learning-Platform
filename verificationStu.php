<!DOCTYPE html>
<html>
<body>
<head>
<link rel="stylesheet" href="verification.css">
</head>
<?php 
session_start();
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "classroom";

    $conn = new mysqli($servername, $username, $password, $dbname);

    
        $_SESSION["email"]=test_input($_POST["email"]);
        $email = $_SESSION["email"];
            $sql3="SELECT email FROM students WHERE email='$email'";
            $res=$conn->query($sql3);
            if($res->num_rows==0){
            echo "Account does not exist! Please Check the Provided Email Account";
            }else{
                $date_clicked = date('Y-m-d H:i:s');
                echo "Time the button was clicked: " . $date_clicked . "<br>";
                $_SESSION['date_clicked'] = $date_clicked;
                header("Location: mailForgotOtpStu.php");
            }
        // else{
        //     $sql2="SELECT email FROM students WHERE email='$email'";
        //     $res=$conn->query($sql2);
        //     // $conn->close();
        //     //if($res->num_rows==0){
        //       //  echo "Account does not exist! Please Check the Provided Email Account";
        //     //}
        //     //else{
        //         $date_clicked = date('Y-m-d H:i:s');
        //         echo "Time the button was clicked: " . $date_clicked . "<br>";
        //         $_SESSION['date_clicked'] = $date_clicked;
        //         header("Location: mailForgotOtp.php");
        //     //}
        // }
    

    $conn->close();

}

?>
<main>
<div class="veri">
<form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <h2 class="title">Verification</h2>
    <h5>Please enter your Email Address for verification</h5>
    <div class="ind">
    <input type="text" name="email" class="input">
    <label for="email" class="label">Email:</label>
    </div>
    <div class="butn">
    <input class="btn" type="submit" name="click" value="Verify">
    </div>
</form>

</div>
</main>
</body>
</html>

<?php
require "PHPMailer.php";
require "Exception.php";
require "SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
$c=0;
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classroom";
$coursecode=$_SESSION["coursecode"];


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn = new mysqli($servername, $username, $password, $dbname);
$recMail = [];

$sql = "select student_email from studentcourses where studentcourses.coursecode = '$coursecode'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($recMail, $row["student_email"]);
    }
}

foreach ($recMail as $var) {
    $mail = new PHPMailer(true);
    $recp = $var;

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';         
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'seventhsanctum22@gmail.com';                  
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          
    $mail->Port       = 465;        
                               
    $mail->setFrom('seventhsanctum22@gmail.com', 'Seventh Sanctum');
    $mail->addAddress($recp); 
    $mail->isHTML(true);
    $a = $_SESSION['test-name'];
    $b = $_SESSION['test-start-time'];
    $c = $_SESSION['test-end-time'];
    $mail->Subject = $a.' Test';
    $mail->Body    = "
                    <body style='text-align:center'>
                    <div style='width:100%' background-color:#d1d1e0;border-style:solid;border-width:1.5px;border-color: #000080;text-align:center;border-radius:10px'>
                    <h1>Dear Student, You have Online $a Test</h1>
                    <h2>Timings: $b to $c</h2>
                    <h2>All The Best.</h2>
                    </div>
                    </body>";
    $mail->AltBody = 'You have '.$a.' test '.' from '. $b .' to '. $c;
    $mail->send();
    $c++;
   
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

}
if($c>0){

echo '<h3>Notification sent to students</h3>';
    echo '
    <form method="post" action="professorHome.php">
    <input type="submit" value="Home">
    </form>
        ';
}

?>
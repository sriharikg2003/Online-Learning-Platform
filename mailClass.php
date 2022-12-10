<?php

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

session_start();
$c = 0;
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classroom";

$coursecode = $_SESSION['coursecode'];
$gmeetLink = $_SESSION["gmeetLink"];
$courseName = $_SESSION['courseName'];
$date = $_SESSION['date'];
$time = $_SESSION['time'];
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

    try {

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'seventhsanctum22@gmail.com';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        //Recipients
        $mail->setFrom('from@example.com', 'Class Schedule');
        $mail->addAddress($recp);


        $message = "<div dir='ltr'><body style='text-align:center ; '>
<div class='message'>
        <h3>Dear Student " . $courseName . " Class is scheduled <br> on " . $date . " at " . $time . "</h3>
                            Use This Link To Join The Class : <br>
                            <a href='$gmeetLink'>" . $gmeetLink . "</a><br>Thank You 
                            
                            </div></div>
                            </body>
                            ";
        $mail->isHTML(true);
        $mail->Subject = $courseName . ' Class scheduled';
        $mail->Body    = $message;
        $mail->AltBody = 'Contact admin ';

        $mail->send();
        $c++;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
if ($c > 0) {
    echo '
    <script>
        alert("Notification Sent to registered students Succesfully")
        window.location = "scheduleClass.php";

    </script>
';
}

?>

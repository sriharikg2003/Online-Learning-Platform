<?php

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classroom";

$coursecode = $_POST['coursecode'];
$courseName = $_POST['courseName'];
$assignment_id = $_POST['assignment_id'];
$email=$_SESSION['email'];
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM professors WHERE email='$email'";

  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $fname = $row['firstname'];
  $lname = $row['lastname'];





$sql = "SELECT * from postassignment where assignment_id = '$assignment_id' ";
$result = $conn->query($sql);

$task="";
$deadline="";
$assigneddate="";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $task = $row["task"];
        $deadline = $row["deadline"];
        $assigneddate = $row["postedtime"];
    }
}

$recMail = [];

$c=0;
$sql = "SELECT student_email from studentcourses where studentcourses.coursecode = '$coursecode' ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($recMail, $row["student_email"]);
        $c=1;
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
        $mail->setFrom('from@example.com', $fname." ".$lname);
        $mail->addAddress($recp);
        $message = "<body '>
<div class='message'>
        <h3>Dear Student ,<br> Gentle Reminder for <br> $courseName Assignment<br><br> Posted on : $assigneddate <br>Deadline  : $deadline .<br><br> 
        Please submit it soon if not yet submitted.
        
                            </div>
                            </body>
                            ";
        $mail->isHTML(true);
        $mail->Subject = 'Reminder for '.$courseName.' Assignment Submission';
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
        alert("Reminder for Assignment Submission is sent successfully")
        window.location = "Assignment.php";

    </script>
    
';
}

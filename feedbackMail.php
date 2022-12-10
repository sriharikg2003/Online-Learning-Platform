<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classroom";

$test_id=$_SESSION['test_id'];
$email=$_SESSION['email'];
$stu_email=$_SESSION['stu_email'];
echo $stu_email;
$coursename="";
$name="";
$testName="";
$conn = new mysqli($servername, $username, $password, $dbname);
    

$sql="SELECT * FROM tests WHERE id='$test_id'";
            $res=$conn->query($sql);
            if($res->num_rows>0){
                $row = $res->fetch_assoc();
                $testName=$row['testName'];
            }

    $sql2="SELECT * FROM professors WHERE email='$email'";
    $res2=$conn->query($sql2);
    if($res2->num_rows>0){
        $row2 = $res2->fetch_assoc();
        $fname=$row2['firstname'];
        $lname=$row2['lastname'];
        $name=$fname.' '.$lname;
    }


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
        require "PHPMailer.php";
        require "Exception.php";
        require "SMTP.php";
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';         
            $mail->SMTPAuth   = true;                                   
            $mail->Username   = 'seventhsanctum22@gmail.com';                  
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          
            $mail->Port       = 465;                                   
            $mail->setFrom('seventhsanctum22@gmail.com', $name);
            $mail->addAddress("$stu_email"); 
            // $otp = rand(100000,999999);
            // $_SESSION['otp_sent']=$otp;
            
            $feed=$_SESSION['feed'];
            $mail->isHTML(true);
            $mail->Subject = 'Test Feedback';
            $mail->Body    = "
                            <h3>Regarding Recent Test: $testName </h3>
                            <body style='text-align:center'>
                            <div style='width:50%' background-color:#d1d1e0;border-style:solid;border-width:1.5px;border-color: #000080;text-align:center;border-radius:10px'>
                            <h5>$feed</h5>
                            </div>
                            </body>";
            // $mail->AltBody = 'Your otp is'.$otp;
            $mail->send();
            // echo 'Message has been sent';
        
        } catch (Exception $e) {
            echo "Unable to send Mail {$mail->ErrorInfo}";
        }
       header("Location:profResp.php");


?>
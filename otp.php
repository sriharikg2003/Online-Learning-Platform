//Creator ->Mandar
<?php
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
    $mail->setFrom('seventhsanctum22@gmail.com', 'Seventh Sanctum');
    $mail->addAddress('210150001@iitdh.ac.in'); 
    $otp = rand(100000,999999);
    $mail->isHTML(true);
    $mail->Subject = 'Your OTP for Seventh Sanctum is';
    $mail->Body    = "<div dir='ltr'>
                    <body style='text-align:center'>
                    <div style='width:50%' background-color:#d1d1e0;border-style:solid;border-width:1.5px;border-color: #000080;text-align:center;border-radius:10px'>
                    <h3>Here is your One Time Password</h3>
                    <h2>$otp</h2>
                    <h4 color='#4d4dff'>Valid for 10 minutes</h4>
                    </div>
                    </div>
                    </body>";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
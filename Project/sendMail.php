<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'src/library/phpmailer/vendor/autoload.php';

//include
include "classes/database.php";
include "classes/MailTable.php";

$db = new Database();
$mailtable = new MailTable($db);
$mailtable->getStudentInfo();

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                                       //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.office365.com';                   //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'documentsubmissionsystem@hotmail.com'; //SMTP username
    $mail->Password   = 'ndvqrgdpuferarre';                     //SMTP password  / App Password
    $mail->SMTPSecure = 'STARTTLS';                             //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('documentsubmissionsystem@hotmail.com', '(Noreply) Daily Summary Report');
    $mail->addAddress('101231636@student.swin.edu.au', '<?php $Convenor->getName() ?>');     //Add a recipient
    
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Daily Summary Report';
    
    $mail->Body= 
    'Hi,
    <br>
    This is an auto generated response email. Please do not reply to this email as it will not be received. 
    <br>
    Feel free to visit document submission <a href="https://www.youtube.com">System Admin Protal</a> for more detail information. 
    <br>
    <br>
    Below is the daily summary of students MCQ results :
    <br>
    COS10009 Introduction to Programming
    <br>
    '. $mailtable->printInfomation() .'

    <br>
    COS20001 User-Centred Design
    <br>
    '. $mailtable->printInfomation() .'
    <br>

    Cheers,
    <br>

    [Document Submission System Team]
    ';
    
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} 

catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    
    //check if the system support SSL
    if (extension_loaded('openssl')) {
        print 'openssl extension loaded.';
    }
}

//Password
// documentsubmissionsystem@hotmail.com  
// mail pasword: swindocsub123456
// App password: ndvqrgdpuferarre 

// testingforswin@hotmail.com 
// mail pasword: swindocsub123456
// App password: qlrqamniuynvlstg
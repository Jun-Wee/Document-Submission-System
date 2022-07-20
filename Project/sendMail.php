<!-- Description: Send Mail function -->
<!-- Author: Jun Wee Tan -->
<!-- Date: 5th July 2022 -->
<!-- Validated: =-->

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
$subscriberEmail  = $mailtable->getSubscribeConvenor();  //retrieve convenor email

$student_result_by_unit = array();
$j =0;
for ($i=0; $i < count($subscriberEmail); $i++) {    //2
    $mailtable->getAll($subscriberEmail[$i]['Email']);

    if (!empty($mailtable->getFullTable())) {  //control only convenor that have student submission and result
        $student_result_by_unit[$j] = [  //each convenor's unit table that content student results
            "name" => $subscriberEmail[$i]['Name'],
            "email" => $subscriberEmail[$i]['Email'],
            "table" => $mailtable->getFullTable()
        ];    
        $j++;
    }
    $mailtable->unsetFullTable();

    //function to update the isSend mail in submission
}

echo "<pre>";
print_r( $student_result_by_unit);
echo "</pre>";

$mail = new PHPMailer(true);

for ($i=0; $i < count($student_result_by_unit); $i++) {  //2 ppl , 2loop
    try {
        //Server settings
        $mail->SMTPDebug = 0;                                       //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.office365.com';                   //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'documentsubmissionsystem@hotmail.com'; //SMTP username
        $mail->Password   = 'wmqejhjaegjckciw';                     //SMTP password  / App Password
        $mail->SMTPSecure = 'STARTTLS';                             //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('documentsubmissionsystem@hotmail.com', '(Noreply) Daily Summary Report');
        $mail->addBCC("101231636@student.swin.edu.au", $student_result_by_unit[$i]["name"]);     //Add a recipient

        
        //Content
        $mail->isHTML(true);  //Set email format to HTML
        $mail->Subject = 'Daily Summary Report';
        
        $mail->Body= 
        'Dear Sir/Madam '. $student_result_by_unit[$i]["name"].',
        <br>
        This is an auto generated response email. Please do not reply to this email as it will not be received. 
        <br>
        Feel free to visit document submission <a href="https://www.youtube.com">System Admin Protal</a> for more detail information. 
        <br>
        <br>
        Below is the daily summary of students MCQ results :
        <br>
        '.$student_result_by_unit[$i]["table"].'
        
               
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
}
//Password
// documentsubmissionsystem@hotmail.com  
// mail pasword: swindocsub123456
// App password: wmqejhjaegjckciw 

// testingforswin@hotmail.com 
// mail pasword: swindocsub123456
// App password: qlrqamniuynvlstg
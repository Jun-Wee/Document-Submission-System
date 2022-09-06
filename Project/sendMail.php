<!-- Description: Send Mail function -->
<!-- Author: Jun Wee Tan -->
<!-- Date: 20th July 2022 -->
<!-- Upadated: 26th Aug 2022: =-->

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
$subscriber = $mailtable->getSubscribeConvenor();  //retrieve convenor email

$student_result_by_unit = array();

$j = 0;
for ($i = 0; $i < count($subscriber); $i++) {    //2
    $subscriberunit = $mailtable->getConvenorUnit($subscriber[$i]['Email']);
    $mailtable->getAllStudentSubmission();

    $test = $mailtable->getFullTable();

    if (!empty($test)) {  //control only convenor that have student submission and result
        $student_result_by_unit[$j] = [  //each convenor's unit table that content student results
            "name" => $subscriberunit[0]['Name'],  //put 0 for always take the same convenor, once the conveor's units has been incresed, it will not affect the loop 
            "email" => $subscriberunit[0]['ConvenorEmail'],
            "table" => $mailtable->getFullTable()
        ];
        $j++;
    }
    $mailtable->unsetFullTable();
    //function to update the isSend mail in submission
}

echo "<pre>";
print_r($student_result_by_unit);
echo "</pre>";


for ($i = 0; $i < count($student_result_by_unit); $i++) {  //2 ppl , 2loop
    $mail = new PHPMailer(true);
    try {
        echo 'start';
        //Server settings
        $mail->SMTPDebug = 0;                                       //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                   //Set the SMTP server to send through  smtp.office365.com
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'noreplyfordssystem@gmail.com'; //SMTP username
        $mail->Password   = 'xaarmrenwohjeoze';                     //SMTP password  / App Password
        $mail->SMTPSecure = 'STARTTLS';                             //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('noreplyfordssystem@gmail.com', '(Noreply) Daily Summary Report');
        $mail->addCC($student_result_by_unit[$i]["email"], $student_result_by_unit[$i]["name"]);     //Add a recipient 


        //Content
        $mail->isHTML(true);  //Set email format to HTML
        $mail->Subject = 'Daily Summary Report';

        $mail->Body =
            'Dear Sir/Madam ' . $student_result_by_unit[$i]["name"] . ',
        <br>
        This is an auto generated response email. Please do not reply to this email as it will not be received. 
        <br>
        Feel free to visit document submission <a href="ec2-3-239-60-63.compute-1.amazonaws.com">System Admin Protal</a> for more detail information. 
        <br>
        <br>
        Below is the daily summary of students MCQ results :
        <br>
        <br>
        ' . $student_result_by_unit[$i]["table"] . '
        
               
        Cheers,
        <br>

        [Document Submission System Team]
        ';

        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

        //check if the system support SSL
        if (extension_loaded('openssl')) {
            print 'openssl extension loaded.';
        }
    }
    $mail->SmtpClose();
}
//Password
// documentsubmissionsystem@hotmail.com  
// mail pasword: swindocsub123456
// App password: hgtdiuwmulplfxcn

// testingforswin@hotmail.com 
// mail pasword: swindocsub123456
// App password: qlrqamniuynvlstg

//noreplyfordssystem@gmail.com
// App password: xaarmrenwohjeoze

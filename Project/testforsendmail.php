<?php
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
            "name" => $subscriberunit[0]['Name'],
            "email" => $subscriberunit[0]['ConvenorEmail'],
            "table" => $mailtable->getFullTable()
        ];
        $j++;
    }
    $mailtable->unsetFullTable();
    //function to update the isSend mail in submission
}
print_r($student_result_by_unit);

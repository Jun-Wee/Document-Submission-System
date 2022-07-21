<?php
include "classes/database.php";
include "classes/SubscribeManager.php";
include "classes/MailTable.php";

$db = new Database();
$mailtable = new MailTable($db);
$subscriber = $mailtable->getSubscribeConvenor();  //retrieve convenor email

echo "Subscriber List";
echo "<pre>";
echo print_r($subscriber);
echo "</pre>";

$student_result_by_unit = array();
$j =0;
for ($i=0; $i < count($subscriber); $i++) {    //2
    $mailtable->getConvenorUnit($subscriber[$i]['Email']);
    $mailtable->getAllStudentSubmission();

    if (!empty($mailtable->getFullTable())) {  //control only convenor that have student submission and result
        $student_result_by_unit[$j] = [  //each convenor's unit table that content student results
            "name" => $subscriber[$j]['Name'],
            "email" => $subscriber[$j]['Email'],
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


?>

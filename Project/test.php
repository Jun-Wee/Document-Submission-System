<?php
include "classes/database.php";
include "classes/SubscribeManager.php";
include "classes/MailTable.php";

$db = new Database();
$mailtable = new MailTable($db);
$subscriberEmail  = $mailtable->getSubscribeConvenor();  //retrieve convenor email

echo "Subscriber List";
echo "<pre>";
echo print_r($subscriberEmail);
echo "</pre>";

$student_result_by_unit = array();

for ($i=0; $i < count($subscriberEmail); $i++) {    //2
    $mailtable->getConvenorUnit($subscriberEmail[$i]['Email']);

    $student_result_by_unit[$i] = [  //each convenor's unit table that content student results
        "name" => $subscriberEmail[$i]['Name'],
        "email" => $subscriberEmail[$i]['Email'],
        "table" => $mailtable->getFullTable()
    ];
    $mailtable->unsetFullTable();
}
print_r($student_result_by_unit);



// echo "<pre>";
// echo print_r($mailList);
// echo "</pre>";



?>

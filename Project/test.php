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

for ($i=0; $i < count($subscriberEmail); $i++) {  
    $mailtable->getConvenorUnit($subscriberEmail[$i]['Email']);
}


// echo "<pre>";
// echo print_r($mailList);
// echo "</pre>";



?>

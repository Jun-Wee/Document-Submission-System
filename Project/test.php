<?php
include "classes/MailTable.php";
include "classes/database.php";

$db = new Database();
$mailtable = new MailTable($db);
$maillist = $mailtable->getStudentInfo();

echo "<pre>";
print_r($maillist);
echo "<pre>";

//formal
echo "<table>";
for ($i=0; $i < count($maillist); $i++) {
    echo "<tr>";
    echo "<td> " . $maillist[$i]['UserId']. "</td>";
    echo "<td> " . $maillist[$i]['Name']. "</td>";
    echo "<td> " . $maillist[$i]['Email']. "</td>";
    echo "</tr>";
}
echo "</table>";


//test in MailTable.php
// $count = 0;
// while ($row = mysqli_fetch_row($queryResult)) {
//     $this->mailList[] = $row[1]; 
//     $count += 1;
// }
// $this->db->closeConnection();

// test
// echo "<table>";
// for ($i=0; $i < count($maillist); $i++) { 
//     echo "<tr>";
//     echo "<td> " . $maillist[$i][0] . "</td>";
//     echo "<td> " . $maillist[$i][1] . "</td>";
//     echo "<td> " . $maillist[$i][2] . "</td>";
//     echo "</tr>";
    
// }
// echo "</table>";


?>

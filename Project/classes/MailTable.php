<?php

class MailTable
{
    private $db;
    private $mailList;

    //constructor
    function __construct($db)
    {
        $this->db = $db;
        $this->mailList = array();
    }

    //function for sendMail.php
    function getStudentInfo()
    {
        //create connection   
        $this->db->createConnection();

        $sql=
        "SELECT S.userid, S.name, B.unitCode, B.id, B.score
        from STUDENTS S
        INNER JOIN SUBMISSION B
        ON S.UserId = B.stuId
        WHERE B.isSendMail = 0";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(),$sql);

        mysqli_stmt_execute($prepared_stmt);

        $queryResult = mysqli_stmt_get_result($prepared_stmt)
        or die("<p>Unable to select from database table</p>");

        mysqli_stmt_close($prepared_stmt);

        //fetch result array
        // mailList[0]{
        //     [UserId] => 101231636
        //     [Name] => Jun Wee Tan
        //     [Email] => 101231636@student.swin.edu.au
        // )...
        while ($row = mysqli_fetch_row($queryResult)) {
            $this->mailList[] = [  //assign every row of retrieve result to mailList[] array
                'UserId'=>$row[0],
                'Name'=>$row[1],
                'unitCode'=> $row[2],
                'SubmissionId'=>$row[3],
                'score'=>$row[4]
            ];
        }
        $this->db->closeConnection();
        return $this->mailList; //return the mailList array
    }

    function printInfomation(){
        $tableMsg = "<table>";
        $tableMsg .= 
        "<tr>
        <th> Student Id </th>
        <th> Name </th>
        <th> Unit Code </th>
        <th> Submission Id </th>
        <th> Score </th>
        </tr>
        "; 
        for ($i=0; $i < count($this->mailList); $i++) {   
            $tableMsg .= "<tr>";
            $tableMsg .= '<td style="padding: 15px;"> ' . $this->mailList[$i]['UserId']. '</td>';
            $tableMsg .= '<td style="padding: 15px;"> ' . $this->mailList[$i]['Name']. '</td>';
            $tableMsg .= '<td style="padding: 15px;"> ' . $this->mailList[$i]['unitCode']. '</td>';
            $tableMsg .= '<td style="padding: 15px;"> ' . $this->mailList[$i]['SubmissionId']. '</td>';
            $tableMsg .= '<td style="padding: 15px;"> ' . $this->mailList[$i]['score']. '</td>';
            $tableMsg .= "</tr>";
        }
        $tableMsg .= "</table>";
        return $tableMsg;
    }

    function getConvenorInfo($Convenoremail){
        $this->db->createConnection();
        $sql = "SELECT Name FROM convenors WHERE Email = ?";
        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);
        $prepared_stmt->bind_param('s',$email);
        $email = $Convenoremail;
        mysqli_stmt_execute($prepared_stmt);
        mysqli_stmt_close($prepared_stmt);
        $db->closeConnection();
    }

    function updateMailInfo($mailernumber, $submissionid){
        // Update mail record in submission database

        // Create connection
        $this->db->createConnection();

        $sql = "UPDATE submission SET isSendMail=1, mailerNo =? WHERE id=?";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Bind input variables to prepared statement
        $prepared_stmt->bind_param('ii', $mailerNo, $id);

        $mailerNo = $mailernumber;
        $id = $submissionid; 

        //Execute prepared statement
        $status = $prepared_stmt->execute();

        mysqli_stmt_close($prepared_stmt);

        $db->closeConnection();

        return $status;
    }

}
<!-- Description: Send Mail function -->
<!-- Author: Jun Wee Tan -->
<!-- Date: 12th July 2022 -->
<!-- Validated: =-->
<?php
class MailTable
{
    private $db;
    private $mailList;
    private $subscribeconvenor;
    private $subscribeconvenorEmail;
    private $unitList;
    private $all_table_with_unicode = "";

    //constructor
    function __construct($db)
    {
        $this->db = $db;
        $this->mailList = array();
        $this->subscribeconvenor = array();
        $this->subscribeconvenorEmail = array();
        $this->unitList = array();
    }

    //function to get subscribe convenor
    function getSubscribeConvenor(){
        $this->db->createConnection();
        $sql = "SELECT Name, Email FROM convenors WHERE isSubscribe = 1";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        mysqli_stmt_execute($prepared_stmt);
        $queryResult = mysqli_stmt_get_result($prepared_stmt)
        or die("<p>Unable to select from database table</p>");

        mysqli_stmt_close($prepared_stmt);

        $i=0;
        while ($row = mysqli_fetch_row($queryResult)) {
            $this->subscribeconvenor[$i] = 
            [  
                'Name'=>$row[0],
                'Email'=>$row[1]
            ];
            $i++;
        }
        $this->db->closeConnection();
        return $this->subscribeconvenor;
    }

    

    //function for get student info to show in email content and save in array
    function getStudentInfo($convenoremail, $unitcode)
    {
        //create connection   
        $this->db->createConnection();

        $sql=
        "SELECT DISTINCT S.userid, S.name, B.unitCode, B.Id, B.score
        from STUDENTS S
        
        INNER JOIN SUBMISSION B
        ON S.UserId = B.stuId
        
        INNER JOIN ENROLMENT E
        ON E.studentId = S.UserId

        INNER JOIN UNIT U
        ON U.code = B.unitCode
        
        INNER JOIN CONVENORS C
        ON C.UserId = U.convenorID
        
        WHERE B.isSendMail = 0
        AND C.Email = ?
        AND B.unitCode = ?
        
        ORDER BY B.unitCode";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(),$sql);

        //Bind input variables to prepared statement
        $convenorEmail = $convenoremail;
        $unitCode = $unitcode;
        $prepared_stmt->bind_param('ss', $convenorEmail, $unitCode);

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
        $i = 0;
        while ($row = mysqli_fetch_row($queryResult)) {
            print_r($row);
            
            $this->mailList[$i] = [  //assign every row of retrieve result to mailList[] array
                'UserId'=>$row[0],
                'Name'=>$row[1],
                'unitCode'=> $row[2],
                'SubmissionId'=>$row[3],
                'score'=>$row[4]
            ];
            $i++;
        }
        print_r($this->mailList);
        $this->db->closeConnection();
        //return $this->mailList;
    }

    //function for printing result array to email body
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

    function getConvenorUnit($convenoremail){
        $this->db->createConnection();
        $sql = "SELECT C.Name, C.Email, U.code 
        FROM CONVENORS C 
        INNER JOIN UNIT U
        ON C.UserId = U.convenorID
        WHERE C.isSubscribe = 1
        AND C.Email = ?
        ORDER BY U.code";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);
        
        $convenorEmail = $convenoremail;
        $prepared_stmt->bind_param('s', $convenorEmail);

        mysqli_stmt_execute($prepared_stmt);
        $queryResult = mysqli_stmt_get_result($prepared_stmt)
        or die("<p>Unable to select from database table</p>");

        mysqli_stmt_close($prepared_stmt);
        $i = 0;
        while ($row = mysqli_fetch_row($queryResult)) {
            $this->unitList[$i] = [  
                'Name'=>$row[0],
                'ConvenorEmail'=>$row[1],
                'UnitCode'=>$row[2]
            ];
            $i++;
        }
        $this->db->closeConnection();
        //return $this->unitList;

        echo "<pre>";
        echo print_r($this->unitList);
        echo "</pre>";
        for ($i=0; $i < count($this->unitList); $i++) { //4
            $this->all_table_with_unicode .= "<h3>".$this->unitList[$i]['UnitCode']."</h3>";
            $this->getStudentInfo($convenoremail, $this->unitList[$i]['UnitCode']);
            $this->all_table_with_unicode .= $this->printInfomation();
            // echo "success";
            // echo "<br>";
        }
        $this->unsetFullList();
        //unset($this->unitList); //reset the unitList after the use of one convenor
    }

    function unsetFullList(){
        $this->unitList = array();
    }

    function getFullTable() {
        return $this->all_table_with_unicode;
    }
    
    function unsetFullTable() {
        $this->all_table_with_unicode = "";
    }

    ///abondon
    function getAllUnit(){
        $this->db->createConnection();
        $sql = "SELECT DISTINCT code, convenorID FROM UNIT";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        mysqli_stmt_execute($prepared_stmt);
        $queryResult = mysqli_stmt_get_result($prepared_stmt)
        or die("<p>Unable to select from database table</p>");

        mysqli_stmt_close($prepared_stmt);

        while ($row = mysqli_fetch_row($queryResult)) {
            $this->unitList = [  
                'UnitCode'=>$row[0],
                'ConvenorId'=>$row[1],
            ];
        }
        $this->db->closeConnection();
        return $this->unitList;
        //invoke the print function
        // foreach ($unitList as $value) {
        //     $value->printInfomation($value);
        // }
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
<?php
//namespace SystemFunction;

class MailTable
{
    private $db;
    private $studentListByUnit;
    private $subscribeconvenor;
    private $subscribeconvenorEmail;
    private $unitList;
    private $all_table_with_unitcode = "";

    //constructor
    function __construct($db)
    {
        $this->db = $db;
        $this->studentListByUnit = array();
        $this->subscribeconvenor = array();
        $this->subscribeconvenorEmail = array();
        $this->unitList = array();
    }

    //function to get subscribe convenor
    function getSubscribeConvenor()
    {
        $this->db->createConnection();
        $sql = "SELECT Name, Email FROM convenors WHERE isSubscribe = 1";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        mysqli_stmt_execute($prepared_stmt);
        $queryResult = mysqli_stmt_get_result($prepared_stmt)
            or die("<p>Unable to select from database table</p>");

        mysqli_stmt_close($prepared_stmt);

        $i = 0;
        while ($row = mysqli_fetch_row($queryResult)) {
            $this->subscribeconvenor[$i] =
                [
                    'Name' => $row[0],
                    'Email' => $row[1]
                ];
            $i++;
        }
        $this->db->closeConnection();
        return $this->subscribeconvenor;
    }


    function getConvenorUnit($convenoremail)
    {
        $this->db->createConnection();
        $sql = "SELECT C.Name, C.Email, U.code
        FROM unit U
        INNER JOIN convenors C
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
                'Name' => $row[0],
                'ConvenorEmail' => $row[1],
                'UnitCode' => $row[2]
            ];
            $i++;
        }
        $this->db->closeConnection();
        echo "<pre>";
        echo print_r($this->unitList);
        echo "<br><br>";
        echo "</pre>";

        return $this->unitList;
    }


    //function for get student info to show in email content and save in array
    function getStudentInfo($convenoremail, $unitcode)
    {
        //create connection   
        $this->db->createConnection();

        $sql =
            "SELECT  S.userid, S.name, B.unitCode, B.Id, B.score
        from students S
        
        INNER JOIN submission B
        ON S.UserId = B.stuId
        
        INNER JOIN unit U
        ON U.code = B.unitCode
        
        INNER JOIN convenors C
        ON C.UserId = U.convenorID
        
        WHERE B.isSendMail = 0
        AND C.Email = ?
        AND B.unitCode =?
        
        ORDER BY B.unitCode";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Bind input variables to prepared statement
        $convenorEmail = $convenoremail;
        $unitCode = $unitcode;
        $prepared_stmt->bind_param('ss', $convenorEmail, $unitCode);

        mysqli_stmt_execute($prepared_stmt);

        $queryResult = mysqli_stmt_get_result($prepared_stmt)
            or die("<p>Unable to select from database table</p>");

        mysqli_stmt_close($prepared_stmt);

        $i = 0;
        while ($row = mysqli_fetch_row($queryResult)) {
            //print_r($row);
            $this->studentListByUnit[$i] = [  //assign every row of retrieve result to studentListByUnit[] array
                'UserId' => $row[0],
                'Name' => $row[1],
                'unitCode' => $row[2],
                'SubmissionId' => $row[3],
                'score' => $row[4]
            ];
            $i++;
        }
        //print_r($this->studentListByUnit);
        // echo "<pre>";
        // print_r($this->studentListByUnit);
        // echo "</pre>";
        $this->db->closeConnection();

        $this->updateSubmissionIsSend($convenorEmail, $unitCode);  //update units's student submission to sent
        return $this->studentListByUnit;
    }

    //function for printing result array to email body
    function printInfomation($unit)
    {
        $tableMsg = '<table>';
        $tableMsg .=
            '
        <h3>' . $unit . '</h3>
        <tr>
        <th> Student Id</th>
        <th> Name </th>
        <th> Unit Code </th>
        <th> Submission Id </th>
        <th> Score </th>
        </tr>
        ';
        for ($i = 0; $i < count($this->studentListByUnit); $i++) {
            $tableMsg .= "<tr>";
            $tableMsg .= '<td style="padding: 15px;"> ' . $this->studentListByUnit[$i]['UserId'] . '</td>';
            $tableMsg .= '<td style="padding: 15px;"> ' . $this->studentListByUnit[$i]['Name'] . '</td>';
            $tableMsg .= '<td style="padding: 15px;"> ' . $this->studentListByUnit[$i]['unitCode'] . '</td>';
            $tableMsg .= '<td style="padding: 15px;"> ' . $this->studentListByUnit[$i]['SubmissionId'] . '</td>';
            $tableMsg .= '<td style="padding: 15px;"> ' . $this->studentListByUnit[$i]['score'] . '</td>';
            $tableMsg .= "</tr>";
        }
        $tableMsg .= '</table>';
        //$this->studentListByUnit = array();  //reset the array
        //print_r($tableMsg);
        return $tableMsg;
    }

    function getAllStudentSubmission()
    {
        for ($i = 0; $i < count($this->unitList); $i++) { //4 units
            $buffer = $this->getStudentInfo($this->unitList[$i]['ConvenorEmail'], $this->unitList[$i]['UnitCode']);

            if (!empty($buffer)) { // if student have submissions in the looping units, concate into the given variable
                $this->all_table_with_unitcode .= $this->printInfomation($this->unitList[$i]['UnitCode']);
            }

            $this->studentListByUnit = array(); //reset the student result Lists (8) to all empty
        }

        $this->unitList = array(); //reset the unitList after the use of one convenor
    }

    function getFullTable()
    {
        return $this->all_table_with_unitcode;
    }

    function unsetFullTable()
    {
        $this->all_table_with_unitcode = "";
    }

    function updateSubmissionIsSend($convenorEmail, $unitCode)
    {
        $this->db->createConnection();
        $sql =
            "UPDATE submission S, unit U, convenors C
        SET S.isSendMail = 1
        WHERE C.Email = ?
        AND S.unitCode = ?
        ";
        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        $convenoremail = $convenorEmail;
        $unitcode = $unitCode;

        $prepared_stmt->bind_param('ss', $convenoremail, $unitcode);
        mysqli_stmt_execute($prepared_stmt);

        mysqli_stmt_close($prepared_stmt);
        $this->db->closeConnection();
    }
}

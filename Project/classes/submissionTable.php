<?php
class SubmissionTable
{
    private $submissions;
    private $db;

    function __construct($db)
    {
        $this->submissions = array();
        $this->db = $db;
    }

    function GetAll($teachingUnits = null)
    {
        // retrieve all submission records from database using database object -->

        // Create connection
        $this->db->createConnection();

        if ($teachingUnits == null) {
            $sql = "SELECT * FROM submission";

            $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

            //Execute prepared statement
            mysqli_stmt_execute($prepared_stmt);

            // Get resultset
            $queryResult =  mysqli_stmt_get_result($prepared_stmt)
                or die("<p>Unable to select from database table</p>");

            // Close the prepared statement
            @mysqli_stmt_close($prepared_stmt);

            $row = mysqli_fetch_row($queryResult);

            $item_count = 0;
            while ($row) {
                // fetch the record from the server and then store them in an object
                $this->submissions[$item_count] = new Submission($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
                $row = mysqli_fetch_row($queryResult);
                $item_count += 1;
            }
        } else {
            for ($i = 0; $i < count($teachingUnits); $i++) {
                $sql = "SELECT * FROM `submission` WHERE `unitCode` = ?";

                $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

                //Bind input variables to prepared statement
                $prepared_stmt->bind_param("s", $teachingUnits[$i]["code"]);

                //Execute prepared statement
                mysqli_stmt_execute($prepared_stmt);

                // Get resultset
                $queryResult =  mysqli_stmt_get_result($prepared_stmt)
                    or die("<p>Unable to select from database table</p>");

                // Close the prepared statement
                @mysqli_stmt_close($prepared_stmt);

                $row = mysqli_fetch_row($queryResult);

                $item_count = 0;
                while ($row) {
                    // fetch the record from the server and then store them in an object
                    array_push($this->submissions, new Submission($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]));
                    $row = mysqli_fetch_row($queryResult);
                    $item_count += 1;
                }
            }
        }

        $this->db->closeConnection();

        return $this->submissions;
    }

    function GetTotalNum()
    {
        // Create connection
        $this->db->createConnection();

        $sql = "SELECT * FROM submission";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Execute prepared statement
        mysqli_stmt_execute($prepared_stmt);

        // Get resultset
        $queryResult =  mysqli_stmt_get_result($prepared_stmt)
            or die("<p>Unable to select from database table</p>");

        // Close the prepared statement
        @mysqli_stmt_close($prepared_stmt);

        $row = mysqli_num_rows($queryResult);

        return $row;
    }

    function Get($subId)
    {
        // Create connection
        $this->db->createConnection();

        $sql = "SELECT * FROM submission WHERE `Id` = ?";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Bind input variables to prepared statement
        $prepared_stmt->bind_param("i", $subId);

        //Execute prepared statement
        mysqli_stmt_execute($prepared_stmt);

        // Get resultset
        $queryResult =  mysqli_stmt_get_result($prepared_stmt)
            or die("<p>Unable to select from database table</p>");

        // Close the prepared statement
        @mysqli_stmt_close($prepared_stmt);

        $row = mysqli_fetch_row($queryResult);

        $this->db->closeConnection();

        return new Submission($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
    }

    function Edit($subId, $submission)
    {
        // Edit submission record from database

        // Create connection
        $this->db->createConnection();

        $sql = "UPDATE `submission` SET `datetime`=?,`score`=?,`unitCode`=?,`filepath`=? WHERE `Id`=?";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Bind input variables to prepared statement
        $prepared_stmt->bind_param("sissi", $datetime, $score, $unitCode, $filepath, $subId);

        $subId = $subId;
        $datetime = $submission->getdatetime();
        $score = $submission->getMCQscore();
        $unitCode =  $submission->getUnitCode();
        $filepath = $submission->getfilepath();

        //Execute prepared statement
        $status = $prepared_stmt->execute();

        $prepared_stmt->close();

        $this->db->closeConnection();

        return $status;
    }

    function Add($submission)
    {
    }

    function Delete($subId)
    {
        // Create connection
        $this->db->createConnection();

        $sql = "DELETE FROM `submission` WHERE `Id` = ?";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Bind input variables to prepared statement
        $prepared_stmt->bind_param("s", $subId);

        //Execute prepared statement
        $queryResult = mysqli_stmt_execute($prepared_stmt);

        // Close the prepared statement
        @mysqli_stmt_close($prepared_stmt);

        $this->db->closeConnection();

        return $queryResult;
    }
}

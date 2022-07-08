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

    function GetAll($convenorId = 0)
    {
        // retrieve all submission records from database using database object -->

        // Create connection
        $this->db->createConnection();

        if ($convenorId == 0) {
            $sql = "SELECT * FROM submission";
        } else {
            $sql = "SELECT * FROM submission";
        }
        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        // if ($convenorId != 0) {
        //     //Bind input variables to prepared statement
        //     $prepared_stmt->bind_param("s", $convenorId);
        // }

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

        $this->db->closeConnection();

        return $this->submissions;
    }

    function Get($subId)
    {
    }

    function Edit($subId, $submission)
    {
    }

    function Add($submission)
    {
    }

    function Delete($subId)
    {
    }
}

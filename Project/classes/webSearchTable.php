<?php
class WebSearchTable
{
    private $db;

    //constructor
    function __construct($db)
    {
        $this->db = $db;
    }

    function Add($organic_results, $subId)
    {
        // Add web search result to database record

        // Create connection
        $this->db->createConnection();

        // loop through the organic_result and insert each result iteratively
        for ($i = 0; $i < 5; $i++) {

            $sql = "INSERT INTO `websearch`(`websearchNum`, `submissionId`, `title`, `description`, `authors`, `link`) VALUES (?,?,?,?,?,?)";

            $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

            //Bind input variables to prepared statement
            $prepared_stmt->bind_param("ssssss", $websearchNo, $submissionId, $title, $description, $authors, $link);

            $websearchNo = $i + 1;
            $submissionId = $subId;
            $title = $organic_results[$i]->title;
            $description = $organic_results[$i]->snippet;
            $summary_arr = explode("-", ($organic_results[$i]->publication_info)->summary);
            $authors = $summary_arr[0];
            $link = $organic_results[$i]->link;

            //Execute prepared statement
            $status = $prepared_stmt->execute();

            $prepared_stmt->close();
        }

        $this->db->closeConnection();

        return $status;
    }

    function GetAll($submissionId)
    {
        // Create connection
        $this->db->createConnection();

        $results = array();

        $sql = "SELECT * FROM websearch WHERE `submissionId` = ?";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Bind input variables to prepared statement
        $prepared_stmt->bind_param("i", $submissionId);

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
            // fetch the record from the server and then store them in an array object
            array_push($results, array("websearchNum" => $row[0], "title" => $row[2], "description" => $row[3], "authors" => $row[4], "link" => $row[5]));
            $row = mysqli_fetch_row($queryResult);
            $item_count += 1;
        }

        $this->db->closeConnection();

        return $results;
    }

    function Delete($subId)
    {
        // Create connection
        $this->db->createConnection();

        $sql = "DELETE FROM `websearch` WHERE `submissionId` = ?";

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

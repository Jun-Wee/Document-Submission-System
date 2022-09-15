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
}

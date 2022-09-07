<?php
class webSearchTable
{
    private $db;

    //constructor
    function __construct($db)
    {
        $this->db = $db;
    }

    function sanitise_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function updateWebSearchResult($data){
        $this->db->createConnection();
        $sql=
        "INSERT INTO websearch (websearchId, submissionId, title, description, authors, link, date)
        VALUES (?,?,?,?,?,?,?)
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

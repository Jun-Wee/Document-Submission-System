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

    function updateWebSearchResult($results,$subId){  //$results content 5 web search results
        $this->db->createConnection();
        $sql=
        "INSERT INTO websearch (websearchId, submissionId, title, description, authors, link)
         VALUES (?,?,?,?,?,?,?)
        ";
        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        for( $i=0; $i < 5; $i++){ //loop each web search result
        $search = $results[$i];
        $splarr = explode("-",$search->displayed_link);
            $title = $search->title;
            $snippet = $search->snippet; 
            $author = $splarr[0];
            $link = $search->link;

            $prepared_stmt->bind_param('sssssss', $i, $subId, $title, $snippet, $author, $link);
            mysqli_stmt_execute($prepared_stmt);
            mysqli_stmt_close($prepared_stmt);
        }
        $this->db->closeConnection();

    }
}

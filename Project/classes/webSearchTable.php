<?php
class webSearchTable
{
    private $db;

    //constructor
    function __construct($db)
    {
        $this->db = $db;
    }

    function sanitise_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function insertWebSearchResult($results, $subId)
    {  //$results content 5 web search results
        $this->db->createConnection();
        for ($i = 0; $i < 5; $i++) {
            $search = $results[$i];

            #explode function is used to seperate the authors from the rest of the filler content in the displayed link which is seperated by a hyphen
            $splarr = explode("-", $search->displayed_link);

            $sql = "INSERT INTO websearch (websearchId, submissionId, title, description, authors, link) VALUES (?,?,?,?,?,?,?)";
            $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

            $prepared_stmt->bind_param('sssssss', $i, $subId, $search->title, $search->snippet, $splarr[0], $search->link);
            mysqli_stmt_execute($prepared_stmt);
            mysqli_stmt_close($prepared_stmt);
        };

        // for ($i = 0; $i < 5; $i++) { //loop each web search result
        //     $search = $results[$i];
        //     $splarr = explode("-", $search->displayed_link);
        //     $title = $search->title;
        //     $snippet = $search->snippet;
        //     $author = $splarr[0];
        //     $link = $search->link;
        // }
        $this->db->closeConnection();
    }
}

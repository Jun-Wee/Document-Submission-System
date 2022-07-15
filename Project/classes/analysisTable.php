<?php

class AnalysisTable {
    private $analysis;
    private $db;

    function __construct($db) {
        $this->analysis = array();
        $this->db = $db;
    }

    function getAll() {                         
        //Retrieve all analysis records of the submission from database using database object
        
        //Create connection to database
        $this->db->createConnection();

        

        //Close connection to database
        $this->db->closeConnection();

        return $this->analysis;
    }

    function get($id) {

    }

    /*function edit($id, $analysis) {
        //Edit existing records of the analysis in the database
    }*/ //Reserved for commenting during meeting

    function add($emotion, $score, $magnitude) {
        //Add a new record of the analysis to the database

        //Create connection to database
        $this->db->createConnection();
        
        //Insert the sentiment analysis value into the database
        $sql = "INSERT INTO `analysis`(`summary`, `sentimentScore`, `sentimentMagnitude`) VALUES (?, ?, ?)";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Bind input variables to prepared statement
        $prepared_stmt->bind_param("sdd", $emotion, $score, $magnitude);

        //Execute prepared statement
        $status = $prepared_stmt->execute();

        $prepared_stmt->close();
        
        //Close connection to database
        $this->db->closeConnection();

        return $status;
    }

    function delete($subId) {
        //Remove an existing record of the analysis from the database

        //Create connection to database
        $this->db->createConnection();
        
        //Delete record
        $sql = "DELETE FROM analysis WHERE subId = ?";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Bind input variables to prepared statement
        $prepared_stmt->bind_param("s", $subId);

        //Execute prepared statement
        $queryResult = mysqli_stmt_execute($prepared_stmt);

        //Close the prepared statement
        @mysqli_stmt_close($prepared_stmt);
        
        //Close connection to database
        $this->db->closeConnection();

        return $queryResult;
    }
}

?>
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

        return $this->db->analysis;
    }

    function get($analysisId) {

    }

    function edit($analysisId, $analysis) {
        //Edit existing records of the analysis in the database
    }

    function add($analysis) {
        //Add a new record of the analysis to the database

        //Create connection to database
        $this->db->createConnection();
        
        
        //Close connection to database
        $this->db->closeConnection();
    }

    function delete($analysis) {
        //Remove an existing record of the analysis from the database
    }
}

?>
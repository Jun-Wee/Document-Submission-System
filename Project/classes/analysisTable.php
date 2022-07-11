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
        $this->db->closeConnection();

        return $this->db->analysis;
    }

    function get($analysisId) {

    }

    function edit($analysisId, $analysis) {

    }

    function add($analysis) {

    }

    function delete($analysis) {
        
    }
}

?>
<?php

class AnalysisTable {
    private $analysis;
    private $db;

    function __construct($db) {
        $this->analysis = array();
        $this->db = $db;
    }

    function getAll() {
        //Create connection to database
        $this->db->createConnection();
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
<?php

class EntityTable {
    private $entity;
    private $db;

    function __construct($db) {
        $this->entity = array();
        $this->db = $db;
    }

    function getAll() {
        //Retrieve all analysis records of the entity from database using database object
        
        //Create connection to database
        $this->db->createConnection();

        

        //Close connection to database
        $this->db->closeConnection();

        return $this->entity;
    }

    function get($id) {

    }

    function add($name, $salience, $link) {
        //Add a new record of the analysis to the database

        //Create connection to database
        $this->db->createConnection();
        
        //Insert the sentiment analysis value into the database
        $sql = "INSERT INTO `entity`(`name`, `salience`, `link`) VALUES (?, ?, ?)";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Bind input variables to prepared statement
        $prepared_stmt->bind_param("sds", $name, $salience, $link);

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
        $sql = "DELETE FROM entity WHERE subId = ?";

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
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

        $sql = "SELECT * FROM entity";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

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

            // fetch the record from the server and then store them in an object
            $this->entity[$item_count] = new Entity($row[0], $row[1], $row[2], $row[3], $row[4]);
            $row = mysqli_fetch_row($queryResult);
            $item_count += 1;
        }

        //Close connection to database
        $this->db->closeConnection();

        return $this->entity;
    }

    function get($subId) {
        //Create connection to database
        $this->db->createConnection();

        $sql = "SELECT * FROM entity WHERE subId = ?";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Bind input variables to prepared statement
        $prepared_stmt->bind_param("i", $subId);

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

        // fetch the record from the server and then store them in an object
        $this->entity[$item_count] = new Entity($row[0], $row[1], $row[2], $row[3], $row[4]);
        $row = mysqli_fetch_row($queryResult);
        $item_count += 1;
     }

        //Close connection to database
        $this->db->closeConnection();

        return $this->entity;
    }

    function add($subId, $name, $salience, $link) {
        //Add a new record of the analysis to the database

        //Create connection to database
        $this->db->createConnection();
        
        //Insert the sentiment analysis value into the database
        $sql = "INSERT INTO `entity`(`subId`, `name`, `salience`, `link`) VALUES (?, ?, ?, ?)";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Bind input variables to prepared statement
        $prepared_stmt->bind_param("isds", $subId, $name, $salience, $link);

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
<?php

class ReferenceTable {
    private $reference;
    private $db;

    function __construct($db) {
        $this->reference = array();
        $this->db = $db;
    }

    function getAll() {                         
        //Retrieve all reference records of the reference from database using database object
        
        //Create connection to database
        $this->db->createConnection();

        $sql = "SELECT * FROM reference";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Bind input variables to prepared statement
        //$prepared_stmt->bind_param("s", $reference);           //Not needed if no value

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
            $this->reference[$item_count] = new Reference($row[0], $row[1], $row[2]);
            $row = mysqli_fetch_row($queryResult);
            $item_count += 1;
        }
        
        //Close connection to database
        $this->db->closeConnection();

        return $this->reference;
    }

    function get($subId) {     
        //Retrieve all reference results based on the submission ID / specific parameter given

        //Create connection to database
        $this->db->createConnection();

        $sql = "SELECT * FROM reference WHERE subId = ?";

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
        $this->reference[$item_count] = new Reference($row[0], $row[1], $row[2]);
        $row = mysqli_fetch_row($queryResult);
        $item_count += 1;
     }

        //Close connection to database
        $this->db->closeConnection();

        return $this->reference;
    }

    function add($subId, $text) {
        //Add a new record of the reference to the database

        //Create connection to database
        $this->db->createConnection();
        
        //Insert the sentiment reference value into the database
        $sql = "INSERT INTO `reference`(`subId`, `text`) 
        VALUES (?, ?)";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Bind input variables to prepared statement
        $prepared_stmt->bind_param("is", $subId, $text);

        //Execute prepared statement
        $status = $prepared_stmt->execute();

        $prepared_stmt->close();
        
        //Close connection to database
        $this->db->closeConnection();

        return $status;
    }

    function delete($subId) {
        //Remove an existing record of the reference from the database

        //Create connection to database
        $this->db->createConnection();
        
        //Delete record
        $sql = "DELETE FROM reference WHERE subId = ?";

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
<?php
class Database
{
    // Properties

    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    function __construct()
    {
        // set the servername,username,password and database name
        $this->servername = "dss.c9ffxxbebyrl.us-east-1.rds.amazonaws.com";
        $this->username = "admin";
        $this->password = "documentsubmissionsystem";
        $this->dbname = "documentsubmissionsystem";
    }

    // Methods
    function createConnection()
    {
        // Create connection
        $this->conn = @mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
        // Check connection
        if (!$this->conn) {
            die("<p>Connection failed: " . mysqli_connect_error() . "</p>");
        }

        // change default database to 'DocumentSubmissionSystem' database
        $dbSelect = @mysqli_select_db($this->conn, $this->dbname);

        if (!$dbSelect) {
            die("<p>The database is not available.</p>");
        }
    }

    function getConnection()
    {
        return $this->conn;
    }

    // Methods
    function closeConnection()
    {
        // close connection
        @mysqli_close($this->conn);
    }
}

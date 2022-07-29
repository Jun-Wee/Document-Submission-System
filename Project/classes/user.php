<?php

class User
{
    // Properties
    protected $name;
    protected $email;
    protected $password;
    protected $id;
    protected $gender;

    function __construct($id, $name, $email, $password, $gender)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->id = $id;
        $this->gender = $gender;
    }

    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->$id = $id;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($name)
    {
        $this->$name = $name;
    }

    function getEmail()
    {
        return $this->email;
    }

    function setEmail($email)
    {
        $this->$email = $email;
    }

    function getPassword()
    {
        return $this->password;
    }

    function setPassword($password)
    {
        $this->$password = $password;
    }

    function getGender()
    {
        return $this->gender;
    }

    function setGender($gender)
    {
        $this->$gender = $gender;
    }
}

class Admin extends User
{
    function fetchAllUnits($db)
    {
        $allUnits = array();

        // Create connection
        $db->createConnection();

        // retrieve all the units codes from the database based on convenor's ID
        $sql = "SELECT * FROM unit";

        $prepared_stmt = mysqli_prepare($db->getConnection(), $sql);

        //Execute prepared statement
        @mysqli_stmt_execute($prepared_stmt);

        // Get resultset
        $queryResult =  @mysqli_stmt_get_result($prepared_stmt)
            or die("<p>Unable to select from database table</p>");

        // Close the prepared statement
        @mysqli_stmt_close($prepared_stmt);

        $row = mysqli_fetch_row($queryResult);

        while ($row) {
            // fetch the unit records from the server and then store them in an array
            array_push($allUnits, array("code" => $row[0], "description" => $row[1], "cp" => $row[2], "type" => $row[3], "convenorID" => $row[4]));
            $row = mysqli_fetch_row($queryResult);
        }
        // foreach ($allUnits as $unit) {
        //     echo $unit['code'] . " " . $unit['description'] . " " . $unit['cp'] . " " . $unit['type'] . " " . $unit['convenorID'] . "\n";
        // }
        $db->closeConnection();
        return $allUnits;
    }
}

class Convenor extends User
{
    // Child Properties
    public $teachingUnits;

    function fetchTeachingUnits($db)
    {
        $this->teachingUnits = array();

        // Create connection
        $db->createConnection();

        // retrieve all the units codes from the database based on convenor's ID
        $sql = "SELECT * FROM unit WHERE convenorID = ?";

        $prepared_stmt = mysqli_prepare($db->getConnection(), $sql);

        //Bind input variables to prepared statement
        mysqli_stmt_bind_param($prepared_stmt, 's', $this->id);

        //Execute prepared statement
        @mysqli_stmt_execute($prepared_stmt);

        // Get resultset
        $queryResult =  @mysqli_stmt_get_result($prepared_stmt)
            or die("<p>Unable to select from database table</p>");

        // Close the prepared statement
        @mysqli_stmt_close($prepared_stmt);

        $row = mysqli_fetch_row($queryResult);

        while ($row) {
            // fetch the unit records from the server and then store them in an array
            array_push($this->teachingUnits, array("code" => $row[0], "description" => $row[1], "cp" => $row[2], "type" => $row[3], "convenorID" => $row[4]));
            $row = mysqli_fetch_row($queryResult);
        }
        // foreach ($this->teachingUnits as $unit) {
        //     echo $unit['code'] . " " . $unit['description'] . " " . $unit['cp'] . " " . $unit['type'] . " " . $unit['convenorID'] . "\n";
        // }
        $db->closeConnection();
        return true;
    }

    function setTeachingUnits($units)
    {
        $this->teachingUnits = $units;
    }

    function getTeachingUnits()
    {
        return $this->teachingUnits;
    }
}

class Student extends User
{
    // Child Properties
    public $enrolledUnits;

    function fetchEnrolledUnits($db)
    {
        $unitsId = array();
        $fetchedUnits = array();
        $this->enrolledUnits = array();

        // Create connection
        $db->createConnection();

        // retrieve all the units codes from the database based on student's ID
        $sql = "SELECT * FROM enrolment WHERE studentId = ?";

        $prepared_stmt = mysqli_prepare($db->getConnection(), $sql);

        //Bind input variables to prepared statement
        mysqli_stmt_bind_param($prepared_stmt, 's', $this->id);

        //Execute prepared statement
        @mysqli_stmt_execute($prepared_stmt);

        // Get resultset
        $queryResult =  @mysqli_stmt_get_result($prepared_stmt)
            or die("<p>Unable to select from database table</p>");

        // Close the prepared statement
        @mysqli_stmt_close($prepared_stmt);

        $row = mysqli_fetch_row($queryResult);

        while ($row) {
            // fetch the unit ids from the server and then store them in an array
            array_push($unitsId, $row[1]);
            $row = mysqli_fetch_row($queryResult);
        }

        foreach ($unitsId as $unitId) {
            // retrieve all the units ids from the database based on student's ID
            $sql = "SELECT * FROM unit WHERE code = ?";

            $prepared_stmt = mysqli_prepare($db->getConnection(), $sql);

            //Bind input variables to prepared statement
            mysqli_stmt_bind_param($prepared_stmt, 's', $unitId);

            //Execute prepared statement
            @mysqli_stmt_execute($prepared_stmt);

            // Get resultset
            $queryResult =  @mysqli_stmt_get_result($prepared_stmt)
                or die("<p>Unable to select from database table</p>");

            // Close the prepared statement
            @mysqli_stmt_close($prepared_stmt);

            $row = mysqli_fetch_row($queryResult);

            while ($row) {
                // fetch the unit ids from the server and then store them in an array
                array_push($fetchedUnits, array("code" => $row[0], "description" => $row[1], "cp" => $row[2], "type" => $row[3], "convenorID" => $row[4]));
                $row = mysqli_fetch_row($queryResult);
            }
        }

        foreach ($fetchedUnits as $unit) {
            // retrieve convenor's name from the database based on convenor's ID
            $sql = "SELECT * FROM convenors WHERE UserId = ?";

            $prepared_stmt = mysqli_prepare($db->getConnection(), $sql);

            //Bind input variables to prepared statement
            mysqli_stmt_bind_param($prepared_stmt, 's', $unit['convenorID']);

            //Execute prepared statement
            @mysqli_stmt_execute($prepared_stmt);

            // Get resultset
            $queryResult =  @mysqli_stmt_get_result($prepared_stmt)
                or die("<p>Unable to select from database table</p>");

            // Close the prepared statement
            @mysqli_stmt_close($prepared_stmt);

            $row = mysqli_num_rows($queryResult);

            if ($row == 1) {
                $row = mysqli_fetch_row($queryResult);
                array_push($this->enrolledUnits, array("code" => $unit['code'], "description" => $unit['description'], "cp" => $unit['cp'], "type" => $unit['type'], "convenorID" => $unit['convenorID'], "convenorName" => $row[1]));
            }
        }
        $db->closeConnection();
        return true;
    }

    function setEnrolledUnits($units)
    {
        $this->enrolledUnits = $units;
    }

    function getEnrolledUnits()
    {
        return $this->enrolledUnits;
    }

    function submitDocument($db, $code, $path)
    {
        // Add submission record to database

        // Create connection
        $db->createConnection();

        $sql = "INSERT INTO `submission`(`stuId`, `datetime`, `score`, `unitCode`, `filepath`) VALUES (?,?,?,?,?)";

        $prepared_stmt = mysqli_prepare($db->getConnection(), $sql);

        //Bind input variables to prepared statement
        $prepared_stmt->bind_param("ssiss", $stuId, $datetime, $score, $unitCode, $filepath);

        $stuId = $this->getId();
        // 2022-06-30 12:59:5
        date_default_timezone_set("Australia/Melbourne");
        $datetime = date("Y-m-d H:i:s");
        $score = 0;
        $unitCode =  $code;
        $filepath = $path;

        //Execute prepared statement
        $status = $prepared_stmt->execute();

        $subId = $db->getConnection()->insert_id;

        $prepared_stmt->close();

        $db->closeConnection();

        return [$status, $subId];
    }
}

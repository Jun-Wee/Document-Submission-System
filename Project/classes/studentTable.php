<?php
class StudentTable
{
    private $students;
    private $db;

    function __construct($db)
    {
        $this->students = array();
        $this->db = $db;
    }

    function GetAll($teachingUnits = null)
    {
        // retrieve all student records from database using database object -->

        // Create connection
        $this->db->createConnection();

        if ($teachingUnits == null) {
            $sql = "SELECT * FROM students";

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
                // $id, $name, $email, $password, $gender
                $this->students[$item_count] = new Student($row[0], $row[1], $row[2], $row[3], $row[5]);
                $row = mysqli_fetch_row($queryResult);
                $item_count += 1;
            }
        } else {
            $studentIds = array();
            for ($i = 0; $i < count($teachingUnits); $i++) {
                $sql = "SELECT `studentId` FROM `enrolment` WHERE `code` = ?";

                $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

                //Bind input variables to prepared statement
                $prepared_stmt->bind_param("s", $teachingUnits[$i]["code"]);

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
                    if (!in_array($row[0], $studentIds)) {
                        array_push($studentIds, $row[0]);
                    }
                    $row = mysqli_fetch_row($queryResult);
                    $item_count += 1;
                }
            }

            for ($i = 0; $i < count($studentIds); $i++) {
                $sql = "SELECT * FROM `students` WHERE `UserId` = ?";

                $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

                //Bind input variables to prepared statement
                $prepared_stmt->bind_param("s", $studentIds[$i]);

                //Execute prepared statement
                mysqli_stmt_execute($prepared_stmt);

                // Get resultset
                $queryResult =  mysqli_stmt_get_result($prepared_stmt)
                    or die("<p>Unable to select from database table</p>");

                // Close the prepared statement
                @mysqli_stmt_close($prepared_stmt);

                $row = mysqli_fetch_row($queryResult);

                $item_count = 0;
                // fetch the record from the server and then store them in an object
                $myStudent = new Student($row[0], $row[1], $row[2], $row[3], $row[5]);
                array_push($this->students, $myStudent);

                $row = mysqli_fetch_row($queryResult);
                $item_count += 1;
            }
        }

        $this->db->closeConnection();

        return $this->students;
    }

    function GetTotalNum()
    {
        // Create connection;
        $this->db->createConnection();

        $sql = "SELECT * FROM students";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Execute prepared statement
        mysqli_stmt_execute($prepared_stmt);

        // Get resultset
        $queryResult =  mysqli_stmt_get_result($prepared_stmt)
            or die("<p>Unable to select from database table</p>");

        // Close the prepared statement
        @mysqli_stmt_close($prepared_stmt);

        $row = mysqli_num_rows($queryResult);

        return $row;
    }

    function Get($studentId)
    {
        // Create connection
        $this->db->createConnection();

        $sql = "SELECT * FROM students WHERE `UserId` = ?";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Bind input variables to prepared statement
        $prepared_stmt->bind_param("i", $studentId);

        //Execute prepared statement
        mysqli_stmt_execute($prepared_stmt);

        // Get resultset
        $queryResult =  mysqli_stmt_get_result($prepared_stmt)
            or die("<p>Unable to select from database table</p>");

        // Close the prepared statement
        @mysqli_stmt_close($prepared_stmt);

        $row = mysqli_fetch_row($queryResult);

        $this->db->closeConnection();

        return new Student($row[0], $row[1], $row[2], $row[3], $row[5]);
    }

    function Edit($studentId, $newStudent)
    {
        // Edit student record from database

        // Create connection
        $this->db->createConnection();

        $sql = "UPDATE `students` SET `Name`=?,`Email`=?,`Gender`=? WHERE `UserId`=?";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Bind input variables to prepared statement
        $prepared_stmt->bind_param("ssss", $name, $email, $gender, $studentId);

        $name = $newStudent->getName();
        $email = $newStudent->getEmail();
        $gender =  $newStudent->getGender();

        //Execute prepared statement
        $status = $prepared_stmt->execute();

        $prepared_stmt->close();

        $this->db->closeConnection();

        return $status;
    }

    function Add($newStudent)
    {
        // Add student record to database

        // Create connection
        $this->db->createConnection();

        $sql = "INSERT INTO `students`(`UserId`, `Name`, `Email`, `Password`, `Role`, `Gender`) VALUES (?,?,?,?,?,?)";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Bind input variables to prepared statement
        $prepared_stmt->bind_param("ssssss", $stuId, $name, $email, $password, $role, $gender);

        $stuId = $newStudent->getId();
        $name = $newStudent->getName();
        $email = 0;
        $password = $newStudent->getPassword();
        $role = "Student";
        $gender = $newStudent->getGender();

        //Execute prepared statement
        $status = $prepared_stmt->execute();

        $prepared_stmt->close();

        $this->db->closeConnection();

        return $status;
    }

    function Delete($studentId)
    {
        // Create connection
        $this->db->createConnection();

        $sql = "DELETE FROM `students` WHERE `UserId` = ?";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Bind input variables to prepared statement
        $prepared_stmt->bind_param("s", $studentId);

        //Execute prepared statement
        $queryResult = mysqli_stmt_execute($prepared_stmt);

        // Close the prepared statement
        @mysqli_stmt_close($prepared_stmt);

        $this->db->closeConnection();

        return $queryResult;
    }
}

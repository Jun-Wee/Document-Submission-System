<!-- Description: QuestionTable class function -->
<!-- Author: Adrian Sim Huan Tze -->
<!-- Date: 22nd July 2022 -->
<!-- Validated: =-->
<?php

class QuestionTable
{
    private $submissionId;
    private $questions;
    private $db;

    function __construct($db, $submissionId)
    {
        $this->questions = array();
        $this->submissionId = $submissionId;
        $this->db = $db;
    }


    # retrieve questions based on the submission Id
    function GetAll()
    {
        // retrieve all question records from database using database object -->

        // Create connection
        $this->db->createConnection();

        $sql = "SELECT * FROM question";

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
            $this->questions[$item_count] = new Question($row[0], $row[2], $row[1], $row[3], $row[4], $row[5], $row[6]);
            $row = mysqli_fetch_row($queryResult);
            $item_count += 1;
        }

        $this->db->closeConnection();

        return $this->questions;
    }

    function GetTotalNumofQues()
    {
        // Create connection;
        $this->db->createConnection();

        $sql = "SELECT * FROM question WHERE submissionId = ?";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Bind input variables to prepared statement
        $prepared_stmt->bind_param(
            "i",
            $this->submissionId
        );

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

    function CalculateTotalScore($actual_answers, $stud_answers)
    {
        $score = 0;
        for ($i = 0; $i < count($stud_answers); $i++) {
            if (in_array($stud_answers[$i], $actual_answers)) {
                $score = $score + 1;
            } else {
                continue;
            }
        }
        return $score;
    }

    function SortQuestions()
    {
    }

    function Get($questionNum)
    {
        // Create connection
        $this->db->createConnection();

        $sql = "SELECT * FROM question WHERE `submissionId` = ? AND `questionNum` = ?";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Bind input variables to prepared statement
        $prepared_stmt->bind_param("ii", $this->submissionId, $questionNum);

        //Execute prepared statement
        mysqli_stmt_execute($prepared_stmt);

        // Get resultset
        $queryResult =  mysqli_stmt_get_result($prepared_stmt)
            or die("<p>Unable to select from database table</p>");

        // Close the prepared statement
        @mysqli_stmt_close($prepared_stmt);

        $row = mysqli_fetch_row($queryResult);

        $this->db->closeConnection();

        // $submissionId, $stuAnswer, $quesNum, $answer, $context, $options, $statement
        return new Question($row[0], $row[2], $row[1], $row[3], $row[4], $row[5], $row[6]);
    }

    function Edit($question)
    {
        // Edit question record from database

        // Create connection
        $this->db->createConnection();

        $sql = "UPDATE `question` SET `stuAnswer`=? WHERE `submissionId`=? AND `questionNum`=?";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Bind input variables to prepared statement
        $prepared_stmt->bind_param("sii", $stuAnswer, $subId, $quesNum);

        $stuAnswer = $question->getStuAnswer();
        $subId = $question->getSubmissionId();
        $quesNum =  $question->getQuesNum();

        //Execute prepared statement
        $status = $prepared_stmt->execute();

        $prepared_stmt->close();

        $this->db->closeConnection();

        return $status;
    }

    function Delete($subId)
    {
        // Create connection
        $this->db->createConnection();

        $sql = "DELETE FROM `question` WHERE `submissionId` = ?";

        $prepared_stmt = mysqli_prepare($this->db->getConnection(), $sql);

        //Bind input variables to prepared statement
        $prepared_stmt->bind_param("s", $subId);

        //Execute prepared statement
        $queryResult = mysqli_stmt_execute($prepared_stmt);

        // Close the prepared statement
        @mysqli_stmt_close($prepared_stmt);

        $this->db->closeConnection();

        return $queryResult;
    }
}

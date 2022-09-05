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
    function GetAll($submissionId)
    {


        return $this->questions;
    }

    function CalculateTotalScore()
    {
    }

    function SortQuestions()
    {
    }

    function Get($questionNum)
    {
    }

    function Edit($questionNum)
    {
    }
}

<!-- Description: Question class function -->
<!-- Author: Adrian Sim Huan Tze -->
<!-- Date: 22nd July 2022 -->
<!-- Validated: =-->
<?php

class Question
{
    private $submissionId;
    private $quesNum;
    private $stuAnswer;
    private $answer;
    private $context;
    private $options;
    private $statement;

    function __construct($submissionId, $stuAnswer, $quesNum, $answer, $context, $options, $statement)
    {
        $this->submissionId = $submissionId;
        $this->stuAnswer = $stuAnswer;
        $this->quesNum = $quesNum;
        $this->answer = $answer;
        $this->context = $context;
        $this->options = $options;
        $this->statement = $statement;
    }

    function getSubmissionId()
    {
        return $this->submissionId;
    }

    function setSubmissionId($newId)
    {
        $this->submissionId = $newId;
    }

    function getStuAnswer()
    {
        return $this->stuAnswer;
    }

    function setStuAnswer($newstuAns)
    {
        $this->stuAnswer = $newstuAns;
    }

    function getQuesNum()
    {
        return $this->quesNum;
    }

    function setQuesNum($quesNum)
    {
        $this->quesNum = $quesNum;
    }

    function getAnswer()
    {
        return $this->answer;
    }

    function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    function getContext()
    {
        return $this->context;
    }

    function setContext($context)
    {
        $this->context = $context;
    }

    function getOptions()
    {
        return $this->options;
    }

    function setOptions($options)
    {
        $this->options = $options;
    }

    function getStatement()
    {
        return $this->statement;
    }

    function setStatement($statement)
    {
        $this->statement = $statement;
    }
}

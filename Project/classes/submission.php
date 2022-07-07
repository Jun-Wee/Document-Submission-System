<?php

class Submission
{
    private $Id;
    private $stuId;
    private $datetime;
    private $mcqScore;
    private $unitCode;
    private $filePath;

    function __construct($Id, $stuId, $datetime, $mcqScore, $unitCode, $filePath)
    {
        $this->Id = $Id;
        $this->stuId = $stuId;
        $this->datetime = $datetime;
        $this->mcqScore = $mcqScore;
        $this->unitCode = $unitCode;
        $this->filePath = $filePath;
    }

    function getId()
    {
        return $this->Id;
    }

    function setId($newId)
    {
        $this->Id = $newId;
    }

    function getstuId()
    {
        return $this->stuId;
    }

    function setstuId($newstuId)
    {
        $this->stuId = $newstuId;
    }

    function getdatetime()
    {
        return $this->datetime;
    }

    function setdatetime($newdatetime)
    {
        $this->datetime = $newdatetime;
    }

    function getMCQscore()
    {
        return $this->mcqScore;
    }

    function setMCQscore($newMCQScore)
    {
        $this->mcqScore = $newMCQScore;
    }

    function getUnitCode()
    {
        return $this->unitCode;
    }

    function setUnitCode($unitCode)
    {
        $this->unitCode = $unitCode;
    }

    function getfilepath()
    {
        return $this->filePath;
    }

    function setfilepath($newfilePath)
    {
        $this->filePath = $newfilePath;
    }
}

<?php

class Analysis {
    private $analysisId;
    private $subId;
    private $type;
    private $summary;
    private $sentimentScore;
    private $sentimentMagnitude;

    //Constructor
    function __construct($analysisId, $subId, $type, $summary, $sentimentScore, $sentimentMagnitude) {
        $this->analysisId = $analysisId;
        $this->subId = $subId;
        $this->type = $type;
        $this->summary = $summary;

        $this->sentimentScore = $sentimentScore;
        $this->sentimentMagnitude = $sentimentMagnitude;
    }

    //Getters and setters-----------------------------------------------------------------------------------
    function getAnalysisId() {
        return $this->analysisId;
    }

    function setAnalysisId($newAnalysisId) {
        return $newAnalysisId;
    }

    function getSubId() {
        return $this->subId;
    }

    function setSubId($newSubId) {
        return $newSubId;
    }

    function getType() {
        return $this->type;
    }

    function setType($newType) {
        return $newType;
    }

    function getSummary() {
        return $this->summary;
    }

    function setSummary($newSummary) {
        return $newSummary;
    }

    function getSentimentScore() {
        return $this->sentimentScore;
    }

    function setSentimentScore($newSentimentScore) {
        return $newSentimentScore;
    }

    function getSentimentMagnitude() {
        return $this->sentimentMagnitude;
    }

    function setSentimentMagnitude($newSentimentMagnitude) {
        return $newSentimentMagnitude;
    }
}

?>
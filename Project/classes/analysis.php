<?php

class Analysis {
    private $analysisId;
    private $subId;
    private $summary;
    private $keywords;
    private $matchedTitles;
    private $sentimentScore;
    private $sentimentMagnitude;

    //Constructor
    function __construct($analysisId, $subId, $summary, $keywords, $matchedTitles, $sentimentScore, $sentimentMagnitude) {
        $this->analysisId = $analysisId;
        $this->subId = $subId;
        $this->summary = $summary;
        $this->keywords = $keywords;
        $this->matchedTitles = $matchedTitles;
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

    function getSummary() {
        return $this->summary;
    }

    function setSummary($newSummary) {
        return $newSummary;
    }

    function getKeywords() {
        return $this->keywords;
    }

    function setKeywords($newKeywords) {
        return $newKeywords;
    }

    function getMatchedTitles() {
        return $this->matchedTitles;
    }

    function setMatchedTitles($newMatchedTitles) {
        return $newMatchedTitles;
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
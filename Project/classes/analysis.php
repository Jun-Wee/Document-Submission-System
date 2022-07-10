<?php

class Analysis {
    private $subId;
    private $summary;
    private $keywords;
    private $matchedTitles;
    private $sentimentAnalysis;

    function __construct($subId, $summary, $keywords, $matchedTitles, $sentimentAnalysis) {
        $this->subId = $subId;
        $this->summary = $summary;
        $this->keywords = $keywords;
        $this->matchedTitles = $matchedTitles;
        $this->sentimentAnalysis = $sentimentAnalysis;
    }

    //Getters and setters-----------------------------------------------------------------------------------
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

    function getSentimentAnalysis() {
        return $this->sentimentAnalysis;
    }

    function setSentimentAnalysis($newSentimentAnalysis) {
        return $newSentimentAnalysis;
    }

    function analysis($subId, $wordCount, $keywords, $references, $matchedTitles) {

    }
}

class EntityAnalysis extends Analysis {

}

?>
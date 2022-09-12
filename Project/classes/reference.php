<?php

class Reference {
    private $referenceId;
    private $subId;
    private $text;

    //Constructor
    function __construct($referenceId, $subId, $text) {
        $this->referenceId = $referenceId;
        $this->subId = $subId;
        $this->text = $text;
    }

    //Getters and setters-----------------------------------------------------------------------------------
    function getReferenceId() {
        return $this->referenceId;
    }

    function setReferenceId($newReferenceId) {
        return $newReferenceId;
    }

    function getSubId() {
        return $this->subId;
    }

    function setSubId($newSubId) {
        return $newSubId;
    }

    function getText() {
        return $this->text;
    }

    function setText($newText) {
        return $newText;
    }
}

?>
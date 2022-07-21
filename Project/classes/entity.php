<?php

class Entity {
    private $entityId;
    private $subId;
    private $name;
    private $salience;
    private $link;

    //Constructor
    function __construct($entityId, $subId, $name, $salience, $link) {
        $this->entityId = $entityId;
        $this->subId = $subId;
        $this->name = $name;
        $this->salience = $salience;
        $this->link = $link;
    }

    //Getters and setters-----------------------------------------------------------------------------------
    function getEntityId() {
        return $this->entityId;
    }

    function setEntityId($newEntityId) {
        return $newEntityId;
    }

    function getSubId() {
        return $this->subId;
    }

    function setSubId($newSubId) {
        return $newSubId;
    }

    function getName() {
        return $this->name;
    }

    function setName($newName) {
        return $newName;
    }

    function getSalience() {
        return $this->salience;
    }

    function setSalience($newSalience) {
        return $newSalience;
    }

    function getLink() {
        return $this->link;
    }

    function setLink($newLink) {
        return $newLink;
    }
}

?>
<?php

class User
{
    // Properties
    public $name;
    public $email;
    public $password;
    public $id;
    public $gender;

    function __construct($id, $name, $email, $password, $gender)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->id = $id;
        $this->gender = $gender;
    }

    function getId()
    {
        return $this->id;
    }

    function getName()
    {
        return $this->name;
    }
}

class Admin extends User{

}

class Convenor extends User{
    // Child Properties
    public $teachingUnits;

    function setTeachingUnits($units){
        $this->$teachingUnits = $units;
    }

    function getTeachingUnits(){
        return $this->$teachingUnits;
    }
}

class Student extends User{
    // Child Properties
    public $enrolledUnits;

    function setEnrolledUnits($units){
        $this->$enrolledUnits = $units;
    }

    function getEnrolledUnits(){
        return $this->$enrolledUnits;
    }
}

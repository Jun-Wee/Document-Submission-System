<?php
class SubscribeManager
{
    private $subscriberlist;

    //constructor
    function __construct()
    {
        $this->subscriberlist = array();
    }

    function subscribe($covenor){
        array_push($this->subscriberlist,$covenor);
    }

    function unsubscribe($covenor){
        array_splice($this->subscriberlist,array_search($covenor,$this->subscriberlist),1);
    }
}

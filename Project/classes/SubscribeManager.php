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
        array_push($subscriberlist,$covenor);
    }

    function unsubscribe($covenor){
        array_splice($subscriberlist,array_search($covenor,$subscriberlist),1);
    }
}
?>
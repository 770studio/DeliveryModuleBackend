<?php

namespace App;



class Assignment
{

    public $Driver;

    function __construct(Driver &$Driver )
    {
        $this->Driver = & $Driver;


    }

    function getDetails() {
        // id will make jsonapi throwing a fatal error, get rid of id
        return  collect( $this->Driver->DeliveryOrder)->forget('id')->toArray();

    }

    function isAccepted() {
        return (bool)$this->Driver->order_id && $this->Driver->order_status; // && $this->Driver->order_status != OrderStatus::asc()->first()->id;
    }


    function isCompleted() {
        return (bool)$this->Driver->order_id && $this->Driver->order_status && $this->Driver->order_status == OrderStatus::asc()->last()->id;
    }
    function isNew() {
        return (bool)$this->Driver->order_id && !$this->Driver->order_status; //&& $this->Driver->order_status == OrderStatus::asc()->first()->id;
    }




}

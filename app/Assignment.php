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





}

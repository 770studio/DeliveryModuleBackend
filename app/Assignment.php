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
    return  collect( $this->Driver->DeliveryOrder)->forget('id')->toArray();

}





}

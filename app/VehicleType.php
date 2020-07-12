<?php

namespace App;

use Illuminate\Database\Eloquent\Model;




class VehicleType extends Model


{
    protected $fillable = ['name', 'code', 'description' ];


    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }







}

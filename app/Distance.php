<?php

namespace App;

use Illuminate\Database\Eloquent\Model;




class Distance extends Model


{
    protected $fillable = ['from', 'to', 'description' ];


    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }







}

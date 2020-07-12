<?php

namespace App;

use Illuminate\Database\Eloquent\Model;




class MerchantType extends Model


{
    protected $fillable = ['name',  'description' ];


    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }







}

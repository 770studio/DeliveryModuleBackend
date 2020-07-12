<?php

namespace App;

use Illuminate\Database\Eloquent\Model;




class VehiclePreference extends Model


{
    protected $table = "vehicle_preference";
    protected $fillable = ['name', 'distance_id', 'description', 'index', 'merchant_type',  'vehicle_type'];


    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }







}

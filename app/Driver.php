<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['name', 'device_id', 'blocked', 'available'];


    public function ping()
     {
         return $this->hasOne('App\Ping');

     }
}

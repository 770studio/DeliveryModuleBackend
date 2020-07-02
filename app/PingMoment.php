<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class PingMoment extends model
{
    protected $table = 'pings_detailed';
    protected $fillable = ['lat', 'long',  'order_status', 'order_id', 'count', 'driver_id'];

    public function Driver()
    {
        return $this->belongsTo('App\Driver');
    }


}

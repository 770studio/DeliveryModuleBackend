<?php

namespace App;



class PingMoment extends Ping
{
    protected $table = 'pings_detailed';
    protected $fillable = ['lat', 'long', 'order_status', 'order_id', 'count'];

/*
    public function driver()
    {
        return $this->belongsTo('App\Driver');
    }*/

}

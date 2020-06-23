<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ping extends Model
{
    protected $fillable = ['lat', 'long', 'order_status', 'order_id', 'count'];

    public function driver()
    {
        return $this->belongsTo('App\Driver');
    }

}

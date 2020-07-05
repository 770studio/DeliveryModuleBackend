<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RejectedOrders extends Model
{

#TODO remove timestamps , make unique index

    public function Driver()
    {
        return $this->belongsTo('App\Driver');
    }
}

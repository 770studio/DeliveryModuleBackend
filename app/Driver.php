<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['name', 'device_id', 'blocked', 'available'];


    public function hasAssignment() {
      return (bool)$this->order_id && $this->order_status != OrderStatus::asc()->last()->id;
  }

    public function PingState() {
        return $this->hasOne('App\Ping', 'driver_id', 'id');
    }
}

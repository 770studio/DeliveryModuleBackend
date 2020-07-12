<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Neomerx\JsonApi\Document\Error as NeomerxError;
use Neomerx\JsonApi\Exceptions\JsonApiException;



class Driver extends Model


{
    protected $fillable = ['name', 'device_id', 'blocked', 'available',  'count', 'lat', 'long', 'order_status', 'order_id', 'vehicle_type'];
    protected $table = "drivers";

    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function hasAssignment() {

        return (bool)$this->order_id; // && $this->order_status != OrderStatus::asc()->last()->id;
    }

    public function RejectedOrders() {
        return $this->hasMany('App\RejectedOrders', 'driver_id', 'id');
    }

    public function PingMoment() {
        return $this->hasMany('App\PingMoment', 'driver_id', 'id');
    }
    public function LastPingMoment() {
        return $this->hasMany('App\PingMoment', 'driver_id', 'id') ->latest()->firstOrFail();

    }

    public function DeliveryOrder() {
        return $this->hasOne('App\DeliveryOrder', 'order_id', 'order_id' );
    }



    function assignOrder( $order_id ) {
        if($this->blocked || !$this->available) return false;
        if(!DeliveryOrder::where('order_id',$order_id )->exists()  ) return false;
        if(Driver::where('order_id',$order_id )->exists() ) return false;

        $this->order_id = $order_id;
        $this->order_status = 0;
        $this->available = 0;
        $this->save();


    }





}

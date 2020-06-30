<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Neomerx\JsonApi\Document\Error as NeomerxError;
use Neomerx\JsonApi\Exceptions\JsonApiException;

class Ping extends Model
{
    protected $fillable = ['lat', 'long',  'order_status', 'order_id', 'count', 'driver_id'];
/*
    public function driver()
    {
        return $this->belongsTo('App\Driver');
    }*/


    protected static function booted()
    {


        return;

        static::creating(function ($ping) {


            $ping->checkin();

            dd(754532333333333, $ping->Driver );
            return false;


             //dd($ping);
            //
        });
    }

    public function Driver()
    {
        return $this->belongsTo('App\Driver');
    }

    function checkin() {
        /*
              1. obtain location update from  driver
              2. response with the current status and "basic config"
              3. what driver needs to know is:
                    - either he is registered or not. if he is not , he shd not be shown the buttons, he might be shown a text that he is not on the list
                    - if he is assigned an order or not
                    - current order status and next order status. button text is next order status
                    - if he is allowed to reject order on the current stage
                    - order details: order id, customer name , address, location, etc...
                      order details is shown by button press

        */

        //dd(66655555555, $request, $request->d);



        $order_statuses = OrderStatus::asc();
        $status_completed = $order_statuses->last();


        // dd($status_completed->status_caption);


        $device_id = $this->driver_id;

        #TODO security check via headers SIGNATURE

        $driver = Driver::where('device_id', $device_id)->where('blocked', 0 )->with('PingState')->first();

        if( !$driver  ) {

            $error =  new NeomerxError(null, null, 405, '405', 'Auth error', 'Driver blocked or doesnt exist');
            throw new JsonApiException($error, 402);

        }


        $this->driver_id = $driver->id;

        $this->lat = round((float)$this->lat, 12) ;
        $this->long= round((float)$this->long, 12);

        if(!$this->lat) unset($this->lat);  // we dont need zero coordinates
        if(!$this->long) unset($this->long);  // its better to retain the last real coordinate instead of updating it with zero



        // create ping and pingmoment


    }








}


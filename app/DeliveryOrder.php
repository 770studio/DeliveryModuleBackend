<?php

namespace App;



use Illuminate\Database\Eloquent\Model;
use Exception;


class DeliveryOrder extends Model
{
    protected $table = 'deliveryorder';
    protected static $do_status = [
        'Not started' => 0,
        'In progress' => 2,
        'Got the location' => 3,
        'Geocoder error' => 4,
        'On hold' => 7,
        'Cancelled' => 9,
        'Completed' => 10,


    ];

    public function Driver()
    {
        return $this->belongsTo('App\Driver' , 'order_id', 'order_id');
    }
    public function DistanceMatrix()
    {
        return $this->hasOne('App\DistanceMatrix' );
    }


    public function scopeNoId($q)
    {

    //    dd($q->first()->forget('id'), 99999999);
     //   return $q->get();
    }


    public function setJobState(  $state )
    {
        $status = @self::getOrderStatus($state) ;
        if(!$status) throw new Exception('Uncatchable: Wrong state name');
        $this->current_status =  $status  ;
        if(! $this->save() ) {
            // TODO critical
        }

       ;
    }

    public static function getJob( $geoJob = false )
    {


        $not_started = self::getOrderStatus('Not started');
        $got_location = self::getOrderStatus('Got the location');
        $cancelled = self::getOrderStatus('Cancelled');

        $state = $geoJob ? [$not_started] : [$got_location, $cancelled]; // either it is geo or assignment  task

        return self::whereIn('current_status', $state )->first();
    }
    public static function getOrderStatus( $status_name )
    {
        return (int)self::$do_status[$status_name];
    }
}

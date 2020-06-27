<?php

namespace App;



use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    protected $table = 'deliveryorder';
    protected static $do_status = [
        'Not started' => 0,
        'In progress' => 1,
        'On hold' => 2,
        'Cancelled' => 3,
        'Completed' => 10,


    ];



    public static function getJob()
    {
        return self::where('current_status', self::getOrderStatus('Not started') )->first();
    }
    public static function getOrderStatus( $status_name )
    {
        return (int)self::$do_status[$status_name];
    }
}

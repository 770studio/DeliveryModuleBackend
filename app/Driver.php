<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Neomerx\JsonApi\Document\Error as NeomerxError;
use Neomerx\JsonApi\Exceptions\JsonApiException;


class Driver extends Model
{
    protected $fillable = ['name', 'device_id', 'blocked', 'available',  'order_status', 'order_id', 'count', 'lat', 'long'];


    public function hasAssignment() {

      return (bool)$this->order_id && $this->order_status != OrderStatus::asc()->last()->id;
  }

    public function PingMoment() {
        return $this->hasMany('App\PingMoment', 'driver_id', 'id');
    }
    public function LastPingMoment() {
        return $this->hasMany('App\PingMoment', 'driver_id', 'id') ->latest()->firstOrFail();
        try {

            $anyone = $this->hasMany('App\PingMoment', 'driver_id', 'id')  ;

            dd( $anyone );



        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function DeliveryOrder() {
        return $this->hasOne('App\DeliveryOrder', 'order_id', 'order_id' );
    }




    function checkin()
    {

        $Driver = &$this;
        // next is not appropriate enough ?
        $_request = app('request');
        // $device_id = $_request->header("X-Device-ID"); // apache_request_headers()["X-Device-ID"] ;
        $data = json_decode($_request->getContent() );

        $order_statuses = OrderStatus::asc();
        $status_completed = $order_statuses->last();


        if(!$data) {
            $error =  new NeomerxError(null, null, 405, '405', 'Payload error', 'No payload');
            throw new JsonApiException($error, 405);
        }


        $data = @$data->data;


        if(!isset( $data->type) || $data->type != 'ping' ) {

            $error =  new NeomerxError(null, null, 405, '405', 'Endpoint error', 'Wrong endpoint');
            throw new JsonApiException($error, 405);

        }




        $data = $data->attributes; // request from app

        $Assignment = [];
        $Status_changed = false; //TODO

        // status change
       // dd( $Driver->hasAssignment() );
        if($Driver->hasAssignment() ) {
            // driver has an order to be delivered

            if($Driver->order_status != @$data->order_status ) {
                #TODO status change


                $Driver->refresh();
            }



            $asgnmt= new Assignment( $Driver );
            $Assignment = $asgnmt->getDetails();




        }




        // create ping and pingmoment
        // ping
        $ping = ['count' => DB::raw('count+1') ]; // always update, driver record shd already exist anyway its created on driver creation

        $lat = round((float)$data->lat, 12) ;
        $long = round((float)$data->long, 12);

        if($lat) $ping ['lat' ] = $lat ; // we dont need zero coordinates
        if($long ) $ping ['long'] = $long ;  // its better to retain the last real coordinate instead of updating it with zero

        $Driver->update( $ping );
        // pingmoment
        //
        // just need to know if the location or status changed
        $ping['count'] = 1; // if insert then 1 if update then count+1
        $last_lat =  round( (float)str_replace(',', '.', $Driver->lat), 12) ;
        $last_long =  round( (float)str_replace(',', '.', $Driver->long), 12) ;
        // location changed or status changed or no pingmoment at all = new record


            // add order id and status
            $ping['order_id'] = (int)@$Driver->order_id;
            $ping['order_status'] = (int)@$Driver->order_status;

        if( !$Driver->PingMoment()->exists() || $Status_changed || ($lat && $lat !=$last_lat) || ($long && $long!= $last_long) ) {
            $Driver->PingMoment()->create( $ping );
        } else  {
            $ping['count'] = DB::raw('count+1');
           // dd($Driver->PingMoment()->);
            $Driver->LastPingMoment()->update( $ping );
        }







        return ['status_changed' => $Status_changed,
                 'order_status'  => $Driver->order_status,
                 'order_status_caption'  => null , //TODO
                 'next_order_status'  => null , //TODO
                 'next_order_status_caption'  => null , //TODO


        ]   +  $Assignment ;


        // return Redirect::to(json_api( )->url()->read('ping', $driver ->id ) );
        // exit;









    }







}

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





    function checkin()
    {

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


        $data = $data->attributes;

        $data->lat = round((float)$data->lat, 12) ;
        $data->long= round((float)$data->long, 12);

        if(!$data->lat) unset($data->lat);  // we dont need zero coordinates
        if(!$data->long) unset($data->long);  // its better to retain the last real coordinate instead of updating it with zero


        // create ping and pingmoment

        $data->count = DB::raw('count+1');

        $this->update((array)$data);


        return ['status_changed' => false ];


        // return Redirect::to(json_api( )->url()->read('ping', $driver ->id ) );
        // exit;


        // PING MOMENT

        /*


                  // just need to know if the location changed
                  $last_lat =  round( (float)str_replace(',', '.', $driver->PingState->lat), 12) ;
                  $last_long =  round( (float)str_replace(',', '.', $driver->PingState->long), 12) ;



                  $count = 0; // updates with same location
                  if( ($data->lat && $data->lat !=$last_lat) || ($data->long && $data->long!= $last_long) ) {
                      $count = DB::raw('count+1');
                  }*/






    }







}

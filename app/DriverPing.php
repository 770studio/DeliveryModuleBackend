<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Neomerx\JsonApi\Document\Error as NeomerxError;
use Neomerx\JsonApi\Exceptions\JsonApiException;



class DriverPing extends Driver
{




    function checkin()
    {
        $Driver = &$this;

        // next is not appropriate enough ?
        $_request = app('request');
        // $device_id = $_request->header("X-Device-ID"); // apache_request_headers()["X-Device-ID"] ;
        $request = json_decode($_request->getContent() );

        $order_statuses = OrderStatus::asc();
        $status_completed = $order_statuses->last();


        if(!$request) {
            $error =  new NeomerxError(null, null, 405, '405', 'Payload error', 'No payload');
            throw new JsonApiException($error, 405);
        }


        $request = @$request->data;


        if(!isset( $request->type) || $request->type != 'ping' ) {

            $error =  new NeomerxError(null, null, 405, '405', 'Endpoint error', 'Wrong endpoint');
            throw new JsonApiException($error, 405);

        }



        // digging deeper
        $request = $request->attributes; // request from app

        $Status_changed = false; //TODO

        // status change

        if($Driver->hasAssignment() ) {
            // driver has an order to deliver

            if($Driver->order_status != @$request->order_status ) {
                #TODO status change


                $Driver->refresh();
            }



            $asgnmt = new Assignment( $Driver );





        }




        // create ping and pingmoment
        // ping
        $ping = ['count' => DB::raw('count+1') ]; // always update, driver record shd already exist anyway its created on driver creation

        $lat = round((float)$request->lat, 12) ;
        $long = round((float)$request->long, 12);

        if($lat) $ping ['lat' ] = $lat ; // we dont need zero coordinates
        if($long ) $ping ['long'] = $long ;  // its better to retain the last real coordinate instead of updating it with zero

        $Driver->update( $ping );
        // pingmoment
        //
        // just need to know if the location or status changed
        // so we track the location changes  as well as  status changes
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
                 'order_accepted'  => isset($asgnmt) && $asgnmt->isAccepted() ?  true : false,
                 'device_id'  => $Driver->device_id,
                 'order_status_caption'  => null , //TODO
                 'next_order_status'  => null , //TODO
                 'next_order_status_caption'  => null , //TODO
                 'assignment' => isset($asgnmt) ?  $asgnmt->getDetails() : null,
                 //'statuses' => OrderStatus::RichArray(),
                 'settings' => [],



        ]    ;


        // return Redirect::to(json_api( )->url()->read('ping', $driver ->id ) );
        // exit;









    }







}

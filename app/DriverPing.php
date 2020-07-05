<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Neomerx\JsonApi\Document\Error as NeomerxError;
use Neomerx\JsonApi\Exceptions\JsonApiException;
use Exception;


class DriverPing extends Driver
{




    function checkin()
    {
        $Driver = &$this;

        $Status_changed = $Order_rejected = false;
        $ErrorMsg = '';

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



        // status change

        if($Driver->hasAssignment() ) {
            // driver has an order to deliver
            $asgnmt = new Assignment( $Driver );

            if(@$request->order_status && $Driver->order_status != @$request->order_status ) {
                #  status change
                try{
                    if( OrderStatus::getNextStatusId( $Driver->order_status )  == $request->order_status ) {
                        $Driver->order_status = $request->order_status;
                        $Driver->save();
                        $Status_changed = true;
                        $Driver->refresh();
                    } else throw new Exception('none conseqentive status');

                    if($asgnmt->isCompleted()) {
                        // free the driver
                        $Driver->available = 1;
                        $Driver->save();

                        $Driver->DeliveryOrder->setJobState('Completed');

                    }

                }  catch(Exception $e) {
                    $Status_changed = false;
                    $ErrorMsg = 'There was a problem with updating the status. Please try again later.';

                }


            }



            if(@$request->reject_order == "yes"  ) {

                #  try to reject
                try{
                    if( OrderStatus::isRejectable( $Driver->order_status  ) ) {

                        $r = new RejectedOrders;
                        $r->driver_id = $Driver->id;
                        $r->order_id = $Driver->order_id;
                        $r->save();

                        $Driver->order_id = 0;
                        $Driver->available = 1;
                        $Driver->save();

                        $Driver->DeliveryOrder->setJobState('Cancelled');

                        $Driver->refresh();

                    } else throw new Exception('unable to reject');


                    $Order_rejected = true;

                }  catch(Exception $e) {
                    $Order_rejected = false;
                    $ErrorMsg = 'There was a problem rejecting the assignment. Please try again later.';
                    //throw new Exception( $e->getMessage() );
                }






            }







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


        $status_id = (int)$Driver->order_status;

        return [
            'status_changed' => $Status_changed,
            'order_rejected' => $Order_rejected,
            'error' => (bool) $ErrorMsg,
            'errorMsg' =>  $ErrorMsg,
            'order_id'  => $Driver->order_id,
            'order_accepted'  => isset($asgnmt) && $asgnmt->isAccepted() ?  true : false,
            'order_completed'  => isset($asgnmt) && $asgnmt->isCompleted() ?  true : false,
            'is_new'  => isset($asgnmt) && $asgnmt->isNew() ?  true : false,

            'device_id'  => $Driver->device_id,

            'order_status_id'  => $status_id,
            'order_status'  => (bool)$status_id,
            'order_status_caption'  => OrderStatus::getStatusCaption( $status_id ),
            'order_status_text'  => OrderStatus::getStatusText( $status_id )  ,
            'order_has_next_status' => (bool)OrderStatus::getNextStatusId( $status_id ),
            'next_order_status_id'  => OrderStatus::getNextStatusId( $status_id ) ,
            'next_order_status_caption'  => OrderStatus::getNextStatusCaption( $status_id ) ,
            'next_order_status_text'  => OrderStatus::getNextStatusText( $status_id ) ,
            'is_rejectable'  => (bool)OrderStatus::isRejectable( $status_id )  ,
            'assignment' => isset($asgnmt) ?  $asgnmt->getDetails() : null,
            //'statuses' => OrderStatus::RichArray(),
            'settings' => [],



        ]    ;


        // return Redirect::to(json_api( )->url()->read('ping', $driver ->id ) );
        // exit;









    }







}

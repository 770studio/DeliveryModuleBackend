<?php

namespace App\Http\Controllers;
use App\OrderStatus;
use CloudCreativity\LaravelJsonApi\Facades\JsonApi;
use CloudCreativity\LaravelJsonApi\Http\Controllers\JsonApiController;
use CloudCreativity\LaravelJsonApi\Http\Requests\CreateResource;
use Illuminate\Http\Request;
use App\Driver;
use App\PingDELETE;
use Illuminate\Support\Facades\DB;
use Neomerx\JsonApi\Document\Error as NeomerxError;
use Neomerx\JsonApi\Exceptions\JsonApiException;
use Illuminate\Support\Facades\Redirect;

class PingController extends JsonApiController
{

  function __construct()
  {

      DB::connection()->enableQueryLog();


  }


    function create($store,  CreateResource $request )
    {
        exit( 'no create' );
    }
    function searching( $request )
    {
        //Request::header('pubapi')
dd(66666666);
        // next is not appropriate enough ?
        $_request = app('request');
        $device_id = $_request->header("X-Device-ID"); // apache_request_headers()["X-Device-ID"] ;
        $data = json_decode($_request->getContent() );

        $order_statuses = OrderStatus::asc();
        $status_completed = $order_statuses->last();



        #TODO security check via headers SIGNATURE

        $driver = Driver::where('device_id', $device_id)->where('blocked', 0 )->first();

        if(!$data) {
            $error =  new NeomerxError(null, null, 405, '405', 'Payload error', 'No payload');
            throw new JsonApiException($error, 405);
        }

        if( !$driver  ) {

            $error =  new NeomerxError(null, null, 405, '405', 'Auth error', 'Driver blocked or doesnt exist');
            throw new JsonApiException($error, 405);

        }

        $data = @$data->data;


        if(!isset( $data->type) || $data->type != 'ping' ) {

            $error =  new NeomerxError(null, null, 405, '405', 'Endpoint error', 'Wrong endpoint');
            throw new JsonApiException($error, 405);

        }

        //dd( $data->attributes, $driver->PingState  );

        $data = $data->attributes;

        $data->lat = round((float)$data->lat, 12) ;
        $data->long= round((float)$data->long, 12);

        if(!$data->lat) unset($data->lat);  // we dont need zero coordinates
        if(!$data->long) unset($data->long);  // its better to retain the last real coordinate instead of updating it with zero


        // create ping and pingmoment

            $data->count = DB::raw('count+1');

            $driver->update((array)$data);



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


    private function checkin_DELETE_IT(   CreateResource $request ) {

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


      $device_id = $request->d;

      #TODO security check via headers SIGNATURE

       $driver = Driver::where('device_id', $device_id)->where('blocked', 0 )->first();
 //            return $this->reply()->content( collect(['items'=> ['error'=> true, 'errmsg'=> 'Driver doesnt exist' ] ])    );
       if( !$driver  ) {
           return $this->reply()->meta(['error'=> true, 'errmsg'=> 'Driver blocked or doesnt exist' ], 405   ) ;
       }

       if( $driver->hasAssignment() ) {
           //TODO reply with
       }

        dd($driver->hasAssignment(), DB::getQueryLog() );
     //  if( $driver->hasAssignment()  )
       // insert it
       dd($driver);

  }
}

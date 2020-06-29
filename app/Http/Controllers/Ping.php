<?php

namespace App\Http\Controllers;
use App\OrderStatus;
use CloudCreativity\LaravelJsonApi\Facades\JsonApi;
use CloudCreativity\LaravelJsonApi\Http\Controllers\JsonApiController;
use Illuminate\Http\Request;
use App\Driver;
use Illuminate\Support\Facades\DB;

class Ping extends JsonApiController
{

  function __construct()
  {
      DB::connection()->enableQueryLog();
  }

    function checkin(Request $request ) {
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

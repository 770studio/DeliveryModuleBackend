<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\DeliveryOrder;
use App\GeoLocation;

class OrderDeliveryService extends Controller
{
  static function RunWithCron() {

      $job = DeliveryOrder::getJob() ;

      if(!$job) return 'no job';

      if($job->delivery_lat == 0 || $job->delivery_long == 0 ) {
         // self::getLocationByAddress
         $geo =  GeoLocation::getLocationByAddress($job->customer_delivery_address ) ;

         if(!$geo) {
             // TODO critical exception
         }
      }



dd( $job->delivery_lat, (bool) $job->delivery_lat, $job->delivery_lat == 0);
     // DeliveryOrder

  }
}

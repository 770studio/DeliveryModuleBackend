<?php

namespace App\Http\Controllers;
use App\Driver;
use App\DistanceMatrix;
use Illuminate\Http\Request;
use App\DeliveryOrder;
use App\VehiclePreference;
use App\GeoLocation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class OrderDeliveryService extends Controller
{
  static function RunWithCron() {




      DB::transaction(function ()   {





          // get free Drivers

  /*    HAVERSINE - not acceptable
          $query = Driver::where('blocked' , 0 )->where('available' , 1)
              ->whereDoesntHave('RejectedOrders', function (Builder $query) use ( $order_id ){
                  $query->where('order_id', $order_id );
              })->limit(1) ;


          $driver = self::haversine($query, $job->merchant_lat, $job->merchant_long, $max_distance = 25000, 'kilometers', ['*'] );
          //   ->first() ;
          $driver = $driver->first();*/





          try{



              $job = DeliveryOrder::getJob( TRUE ) ;
              if(!$job) {

                  dump( 'no job');
                  return;
              }

              $prevState = $job->current_status;
              $order_id = $job->order_id;
              $job->setJobState(  'In progress' );




              $availableDrivers = Driver::where('blocked' , 0 )->where('available' , 1)
                  ->whereDoesntHave('RejectedOrders', function (Builder $query) use ( $order_id ){
                      $query->where('order_id', $order_id );
                  }) ->get();


              $origin = [$job->customer_delivery_address];

              $dests = 0;
              foreach($availableDrivers as $item) {
                  if($item->lat || $item->long) {
                      $dests++;
                      $item->destination = $item->lat . ',' . $item->long;
                        //$dests[$item->id]  = $item->lat . ',' . $item->long;
                  }
              }

              $destinations = $availableDrivers->where('destination', "!=", false )->pluck(  'destination', 'id' ) ;


              if(!$destinations) {
                  // no driver
                  //  $job->current_status = $prevState;
                  //  $job->save();


                  throw new Exception("no driver" ); // transaction roll back current_status
              }

              $data = DistanceMatrix::Calculate($origin, $destinations->toArray()  );
              $geodata = json_decode($data);
              if(!$geodata) {

                  Log::debug( $data);
                  throw new Exception( "json can not be parsed" );

              }

                if($geodata->status != "OK") {
                    Log::debug( $geodata );
                    throw new Exception( "bad googleapi status:" . $geodata->status );
                }

                 // merge distance into $availableDrivers
                  $k = 0;
                  foreach($destinations as $id=>$d ) {

                      if(isset($geodata->rows[0]->elements[$k]))
                          $availableDrivers->find($id)->distance = $geodata->rows[0]->elements[$k]->distance->value;
                          $k++;

                  }

                 // pick one
              $driver = self::filterDrivers(  $availableDrivers, $job->merch_type );
              if(!$driver) {
                  $driver = $availableDrivers->where('distance', "!=", false )->first(); // anyone ?
              }

              if(!$driver) {
                  // no driver
                  throw new Exception("no driver" ); // transaction roll back current_status
              }

              if(!$driver->assignOrder( $order_id ) )  {

                  #TODO critical exception
                  throw new Exception("Order not assigned" );



              }



          } catch(Exception $e) {
              $err = $e->getMessage();
              dump( $err );
              Log::debug( $err);
              exit; // transaction roll back current_status
          }





          dump( "Order " . $order_id  . " assigned successfully" );






      });



  }


private function filterDrivers( Collection & $drvrs, $merch_type ) {

      $prefs = VehiclePreference::Filtering();

      foreach($prefs as $pref) {
          $filtered = $drvrs->filter(function ($item, $key) use ($pref, $merch_type) {
              return
                  $item->vehicle_type == $pref->vehicle_type   // Vehicle type matches
                  && ( ! $pref->merchant_type  || $pref->Mtype->name  ==  $merch_type)   // merchant  type matches
                  && ( isset($item->distance) && $item->distance >= $pref->Distance->from && $item->distance <= $pref->Distance->to )  //  distance  matches
                  ;
          });

          if($filtered) return $filtered;
      }

    return false;



}








    /*
     *  find the n closest locations
     *  @param Model $query eloquent model
     *  @param float $lat latitude of the point of interest
     *  @param float $lng longitude of the point of interest
     *  @param float $max_distance distance in miles or km
     *  @param string $units miles or kilometers
     *  @param Array $fiels to return
     *  @return array
     */
    public static function haversine($query, $lat, $lng, $max_distance = 25, $units = 'miles', $fields = false )
    {

        if(empty($lat)){
            $lat = 0;
        }

        if(empty($lng)){
            $lng = 0;
        }

        /*
         *  Allow for changing of units of measurement
         */
        switch ( $units ) {
            case 'miles':
                //radius of the great circle in miles
                $gr_circle_radius = 3959;
                break;
            case 'kilometers':
                //radius of the great circle in kilometers
                $gr_circle_radius = 6371;
                break;
        }

        /*
         *  Support the selection of certain fields
         */
        if( ! $fields ) {
            $fields = array( 'users.*', 'users_profile.*', 'users.username as user_name' );
        }

        /*
         *  Generate the select field for disctance
         */
        $distance_select = sprintf(
            "           
					                ROUND(( %d * acos( cos( radians(%s) ) " .
            " * cos( radians( lat ) ) " .
            " * cos( radians( `long` ) - radians(%s) ) " .
            " + sin( radians(%s) ) * sin( radians( lat ) ) " .
            " ) " .
            ")
        							, 2 ) " .
            "AS distance
					                ",
            $gr_circle_radius,
            $lat,
            $lng,
            $lat
        );

        $data = $query->select( DB::raw( implode( ',' ,  $fields ) . ',' .  $distance_select  ) )
            ->having( 'distance', '<=', $max_distance )
            ->orderBy( 'distance', 'ASC' )
            ->get();

       // echo '<pre>';
       //  echo $query->toSQL();
       //  echo $distance_select;
        // echo '</pre>';
        // die();
        //
        //$queries = DB::getQueryLog();
        //$last_query = end($queries);
        //var_dump($last_query);
        //die();
        return $data;
    }









}

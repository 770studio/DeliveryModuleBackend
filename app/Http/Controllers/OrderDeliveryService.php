<?php

namespace App\Http\Controllers;
use App\Driver;
use Illuminate\Http\Request;
use App\DeliveryOrder;
use App\GeoLocation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class OrderDeliveryService extends Controller
{
  static function RunWithCron() {




      DB::transaction(function ()   {

          $job = DeliveryOrder::getJob() ;
          if(!$job) {

              dump( 'no job');
              return;
          }

          $prevState = $job->current_status;
          $order_id = $job->order_id;
          $job->setJobState(  'In progress' );




          // get free Drivers
          $query = Driver::where('blocked' , 0 )->where('available' , 1)
              ->whereDoesntHave('RejectedOrders', function (Builder $query) use ( $order_id ){
                  $query->where('order_id', $order_id );
              })->limit(1) ;


          $driver = self::haversine($query, $job->merchant_lat, $job->merchant_long, $max_distance = 25000, 'kilometers', ['*'] );
          //   ->first() ;
          $driver = $driver->first();


          if(!$driver) {
              // no driver
              $job->current_status = $prevState;
              $job->save();

              dump(  "no driver" );
          }


          elseif(!$driver->assignOrder( $order_id ) )  {

              #TODO critical exception
              dump(  "Order not assigned" );

              //  'In progress'
          }  else dump( "Order assigned successfully" );



      });



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

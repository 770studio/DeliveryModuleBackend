<?php

namespace App;



use Illuminate\Database\Eloquent\Model;
use Exception;
use Spatie\Geocoder\Geocoder;

class DistanceMatrix extends Model
{

    protected $table = "distance_matrix";
    protected $guarded = [];

    public function DeliveryOrder()
    {
        return $this->belongsTo('App\DeliveryOrder' );
    }



    public static function Calculate($origins, $destinations, $jobId ) {
        $client = new \GuzzleHttp\Client(['verify' => false ]);

        $res = $client->request('GET', 'https://maps.googleapis.com/maps/api/distancematrix/json?', [
             'query' => [
                 'key' =>  config('geocoder.key'),
                 'units'=> 'metric',
                 'origins' => implode('|', $origins ),
                 'destinations' => implode('|', $destinations ),

             ]
        ]);

        if($res->getStatusCode() != 200 ) {
            $err = 'googleapis returned bad status: ' . $res->getStatusCode();
            Log::debug( $err );
            Log::debug($origins, $destinations );
            // TODO notify
            throw new Exception( $err );
        }

       // echo $res->getHeader('content-type')[0];
// 'application/json; charset=utf8'
       $body =  $res->getBody();

        //save for future debug, TODO can be omitted on production
        DistanceMatrix::updateOrCreate(
            ['id' => $jobId],
            ['data' =>$body]
        );


        return $body;
    }






}

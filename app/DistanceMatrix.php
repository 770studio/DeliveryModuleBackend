<?php

namespace App;



use Illuminate\Database\Eloquent\Model;
use Spatie\Geocoder\Geocoder;

class DistanceMatrix extends Model
{

    public function DeliveryOrder()
    {
        return $this->belongsTo('App\DeliveryOrder' );
    }



    public static function Calculate($origins, $destinations) {
        $client = new \GuzzleHttp\Client(['verify' => false ]);

        $res = $client->request('GET', 'https://api.github.com/user', [
             'query' => [
                 'key' =>  config('geocoder.key'),
                 'units'=> 'metric',
                 'origins' => implode('|', $origins ),
                 'destinations' => implode('|', $destinations ),

             ]
        ]);
        echo $res->getStatusCode();
// "200"
        echo $res->getHeader('content-type')[0];
// 'application/json; charset=utf8'
        echo $res->getBody();


    }



 //         $location = new GeoLocation;
    //
    //        $location->location = json_encode($geo);
    //
    //        $location->save();



}

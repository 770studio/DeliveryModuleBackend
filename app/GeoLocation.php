<?php

namespace App;



use Illuminate\Database\Eloquent\Model;
use Spatie\Geocoder\Geocoder;

class GeoLocation extends Model
{


    protected $table = 'geolocation';


    public static function getLocationByAddress( $address )
    {

        $client = new \GuzzleHttp\Client(['verify' => false ]);

        $geocoder = new Geocoder($client);

        $geocoder->setApiKey(config('geocoder.key'));

        $geocoder->setCountry(config('geocoder.country', 'US'));

        $geo = $geocoder->getCoordinatesForAddress( $address );

        if(!$geo) return false;

        $location = new GeoLocation;

        $location->location = json_encode($geo);

        $location->save();

        return [
            'id' => $location->id,
            'lat' => $geo['lat'],
            'lng' => $geo['lng'],
            'accuracy' => $geo['accuracy'],
            'formatted_address' => $geo['formatted_address'],

        ];
      //  dd($location-);

       // $location->



    }

}

<?php

namespace App\Http\Controllers;

use App\DeliveryOrder;
use App\GeoLocation;
use Exception;

class GeoCoder extends Controller
{
    static function RunWithCron()
    {

        $job = DeliveryOrder::getJob(true);

        if (!$job) return 'no job';

        // make cache or at least check the db for the same address

        // started
        $job->setJobState('In progress');


        $geo = GeoLocation::getLocationByAddress($job->customer_delivery_address);
        if (!$geo) {
            // TODO critical exception
            throw new Exception('Geocoder error');
        }



        $job->delivery_lat = $geo['lat'];
        $job->delivery_lng = $geo['lng'];
        $job->geo_accuracy = $geo['accuracy'];
        $job->formatted_address = $geo['formatted_address'];
        $job->location_id = $geo['id'];

        if (!$job->save()) {
            // TODO critical exception
            throw new Exception('Job saving  error');

        }

        $job->setJobState( 'Got the location' );

        return 'job done';
    }
}

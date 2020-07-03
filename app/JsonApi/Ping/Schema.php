<?php

namespace App\JsonApi\Ping;

use Exception;
use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'ping';

    /**
     * @param \App\PingDELETE $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {

     // if(!$resource->getRouteKey()) throw new Exception('no id');
     //   return (string) $resource->getRouteKey();
        return (string) $resource->id ;
    }

    /**
     * @param \App\PingDELETE $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes( $Driver )
    {



        //dd(9999999,$resource, $resource->hasAssignment()  ); // $resource->Driver->hasAssignment(
      //  $driver->hasAssignment();
        #TODO security check via headers SIGNATURE


 // mutation

        return  $Driver->checkin() ;
    }
}

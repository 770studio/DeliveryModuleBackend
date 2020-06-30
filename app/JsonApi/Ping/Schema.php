<?php

namespace App\JsonApi\Ping;

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
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\PingDELETE $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($Driver)
    {

        //dd(9999999,$resource, $resource->hasAssignment()  ); // $resource->Driver->hasAssignment(
      //  $driver->hasAssignment();
        #TODO security check via headers SIGNATURE




        return  $Driver->checkin() +
            [
            'created-at' => $Driver->created_at->toAtomString(),
            'updated-at' => $Driver->updated_at->toAtomString(),
        ];
    }
}

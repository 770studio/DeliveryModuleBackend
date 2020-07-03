<?php

namespace App\JsonApi\DriverVehicles;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'driver_vehicles';

    /**
     * @param \App\Driver $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Driver $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'name' => $resource->name,
            'device_id' => $resource->device_id,
            'blocked' => (bool) $resource->blocked,
            'available' => (bool) $resource->available,
            'lat' => $resource->lat,
            'long' => $resource->long,
            'order_id' => $resource->order_id,
            'order_status' => $resource->order_status,
             'created-at' => $resource->created_at->toAtomString(),
             'updated-at' => $resource->updated_at->toAtomString(),
        ];
    }


    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [

        ];
    }





}

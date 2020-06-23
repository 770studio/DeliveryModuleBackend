<?php

namespace App\JsonApi\Pings;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'pings';

    /**
     * @param \App\Ping $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Ping $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'date' => $resource->date,
            'driver_id' => $resource->driver_id,
            'lat' => $resource->lat,
            'long' => $resource->long,
            'count' => $resource->count,
            'order_status' => $resource->order_status,
            'order_id' => $resource->order_id,
            'rejected_orders' => $resource->rejected_orders,
            'created-at' => $resource->created_at->toAtomString(),
            'updated-at' => $resource->updated_at->toAtomString(),
        ];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'driver' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
            ]
        ];
    }


}

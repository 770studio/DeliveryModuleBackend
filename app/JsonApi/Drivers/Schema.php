<?php

namespace App\JsonApi\Drivers;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'drivers';

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
            'blocked' => $resource->blocked,
            'available' => $resource->available,
           // 'created-at' => $resource->created_at->toAtomString(),
           // 'updated-at' => $resource->updated_at->toAtomString(),
        ];
    }


    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'ping' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
            ]
        ];
    }





}

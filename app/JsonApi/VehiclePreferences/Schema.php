<?php

namespace App\JsonApi\VehiclePreferences;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'vehicle_preferences';

    /**
     * @param \App\VehiclePreference $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\VehiclePreference $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'name' => $resource->name,
            'distance_id' => $resource->distance_id,
            'merchant_type' => $resource->merchant_type,
            'vehicle_type' => $resource->vehicle_type,
            'index' => $resource->index,
            'description' => $resource->description,
            'created-at' => $resource->created_at->toAtomString(),
            'updated-at' => $resource->updated_at->toAtomString(),
        ];
    }
}

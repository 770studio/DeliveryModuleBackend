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
    {   dd(9999999, $resource->Driver->hasAssignment() );
      //  $driver->hasAssignment();


        return [
            'created-at' => $resource->created_at->toAtomString(),
            'updated-at' => $resource->updated_at->toAtomString(),
        ];
    }
}

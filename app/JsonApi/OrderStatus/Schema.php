<?php

namespace App\JsonApi\OrderStatus;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'order_status';

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
            'index' => $resource->index,
            'is_rejectable' => (bool) $resource->is_rejectable,
            'caption' => $resource->status_caption,
            'text' => $resource->status_text,
           // 'parent_id' => 0,

        ];
    }


    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [

        ];
    }





}

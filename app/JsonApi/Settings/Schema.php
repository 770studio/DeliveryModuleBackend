<?php

namespace App\JsonApi\Settings;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'settings';

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
            'value' => $resource->value,
            'setting_type' => $resource->setting_type,



        ];
    }


    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [

        ];
    }





}

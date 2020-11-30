<?php

namespace App\JsonApi\PaktecCompetitorsItems;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'paktec-competitors-items';

    /**
     * @param \App\PaktecCompetitorsItem $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\PaktecCompetitorsItem $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'title' => $resource->title,
            'listing_id' => $resource->listing_id,
            'origin_id' => $resource->origin_id,
            'option_text' =>  $resource->title . '(' . $resource->listing_id . ')',

            'created-at' => $resource->created_at->toAtomString(),
            'updated-at' => $resource->updated_at->toAtomString(),
        ];
    }
}

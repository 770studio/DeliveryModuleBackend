<?php

namespace App\JsonApi\PaktecOwnItems;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'paktec-own-items';

    /**
     * @param \App\PaktecOwnItem $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\PaktecOwnItem $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {



        return [
            'title' => $resource->title,
            'listing_id' => $resource->listing_id,
            'price' => $resource->price,
            'best_seller' => $resource->best_seller,

            //
            'track' =>  (bool) $resource->track,
            'option_text' =>  $resource->title . '(' . $resource->listing_id . ')',

             'created-at' => $resource->created_at->toAtomString(),
            'updated-at' => $resource->updated_at->toAtomString(),
        ];
    }
}

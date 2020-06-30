<?php

namespace App\JsonApi\Ping;

use App\Ping;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

use Neomerx\JsonApi\Document\Error as NeomerxError;
use Neomerx\JsonApi\Exceptions\JsonApiException;

class Adapter extends AbstractAdapter
{

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Mapping of JSON API filter names to model scopes.
     *
     * @var array
     */
    protected $filterScopes = [];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new Ping(), $paging);
    }

    /**
     * @param Builder $query
     * @param Collection $filters
     * @return void
     */
    protected function filter($query, Collection $filters)
    {
        $this->filterWithScopes($query, $filters);
    }


    /**
     * @param
     * @param $resource
     * @return void
     */
    protected function creating( Ping $ping, $resource)
    {
/*
$error =  new NeomerxError(
            null,
            null,
            402,
            '402',
            'Payment Required',
            'Detaiol Required'

        );


        throw new JsonApiException($error, 402);
*/
       // dd($ping, $resource);
        //$video->{$video->getKeyName()} = $resource['id'];
    }


}

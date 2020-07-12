<?php

namespace App\JsonApi\VehiclePreferences;

use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

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
        parent::__construct(new \App\VehiclePreference(), $paging);
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


    protected function updating(   $vp, $resource )
    {
      //  Log::debug('updating.');
      //  Log::debug( $vp );
      //  Log::debug( $resource );

       // if( $resource['attributes']['description'] == null )
        if($vp->description == null)
                         $vp->description =  '';

    }


    protected function creating(   $vp, $resource )
    {

        if($vp->description == null)
            $vp->description =  '';

    }

}

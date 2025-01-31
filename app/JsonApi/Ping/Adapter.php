<?php

namespace App\JsonApi\Ping;

use App\DriverPing;

use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

use Exception;
use Neomerx\JsonApi\Contracts\Encoder\Parameters\EncodingParametersInterface;
use Neomerx\JsonApi\Document\Error as NeomerxError;
use Neomerx\JsonApi\Exceptions\JsonApiException;

class Adapter extends AbstractAdapter
{


    protected $primaryKey = 'device_id';
    protected $fillable = ['count']; // no direct updates

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
//dd(999999999);
// the only possible is GET ping/DEVICE_ID
        parent::__construct(new DriverPing(), $paging);






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


    protected function reading( $record, $request) {
dd(6666666);

    }


    protected function creating( $ping, $resource)
    {
       // throw new Exception("Ain't no create");
        dd(777777777);
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




     protected function queryAll($query, EncodingParametersInterface $parameters) {

       return false;
         dd(333333333);
    }






}

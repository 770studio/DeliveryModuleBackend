<?php

namespace App\Providers;



use CloudCreativity\LaravelJsonApi\Document\Error\Error;
use Illuminate\Support\ServiceProvider;
use App\OrderStatus;
use Neomerx\JsonApi\Document\Error as NeomerxError;
use Neomerx\JsonApi\Exceptions\JsonApiException;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
/*         OrderStatus::saving (function ( $data ) {



             $error =  new NeomerxError(
                 null,
                 null,
                 402,
                 '402',
                 'Payment Required',
                 'Detaiol Required'

             );


             throw new JsonApiException($error, 402);



        });*/
    }
}

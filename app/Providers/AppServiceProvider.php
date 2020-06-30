<?php

namespace App\Providers;



use CloudCreativity\LaravelJsonApi\Document\Error\Error;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use App\OrderStatus;
use Neomerx\JsonApi\Document\Error as NeomerxError;
use Neomerx\JsonApi\Exceptions\JsonApiException;
use Illuminate\Support\Facades\File;


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


        //  лог всех mysql запросов
        DB::listen(function($query) {
            File::append(
                storage_path('/logs/query.log'),
                date("r") . ":" . $query->time . ":" . $query->sql . ' [' . implode(', ', $query->bindings) . ']' . PHP_EOL
            );
        });










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

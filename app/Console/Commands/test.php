<?php

namespace App\Console\Commands;

use CloudCreativity\LaravelJsonApi\Document\Error\Error;
use Illuminate\Console\Command;

use Neomerx\JsonApi\Exceptions\JsonApiException;
use Neomerx\JsonApi\Document\Error as NeomerxError;


class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //
        $error =  new NeomerxError(
            null,
            null,
            402,
            '402',
            'Payment Required',
            'Detaiol Required'

        );


            throw new JsonApiException($error, 402);


    }
}

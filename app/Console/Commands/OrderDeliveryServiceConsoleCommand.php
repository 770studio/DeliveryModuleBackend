<?php

namespace App\Console\Commands;

use App\Http\Controllers\OrderDeliveryService;
use Illuminate\Console\Command;
//use Spatie\Geocoder\Facades\Geocoder;
use Spatie\Geocoder\Geocoder;

class OrderDeliveryServiceConsoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dservice:run';

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
     * @return mixed
     */
    public function handle()
    {

        $client = new \GuzzleHttp\Client(['verify' => false ]);

        $geocoder = new Geocoder($client);

        $geocoder->setApiKey(config('geocoder.key'));

        $geocoder->setCountry(config('geocoder.country', 'US'));

        $geo = $geocoder->getCoordinatesForAddress('Infinite Loop 1, Cupertino');


        dd(
            $geo
        );

        // Geocoder::getCoordinatesForAddress('Samberstraat 69, Antwerpen, Belgium')

        //OrderDeliveryService::RunWithCron();
    }
}

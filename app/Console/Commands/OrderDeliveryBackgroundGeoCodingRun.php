<?php

namespace App\Console\Commands;


use App\Http\Controllers\GeoCoder;
use Illuminate\Console\Command;

class OrderDeliveryBackgroundGeoCodingRun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geocoder:run';

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

      //11.07.2020  dont need geocoding  AS WE ARE USING DISTANCE MARTIX
     //  echo  GeoCoder::RunWithCron();
        // Geocoder::getCoordinatesForAddress('Samberstraat 69, Antwerpen, Belgium')
    }
}

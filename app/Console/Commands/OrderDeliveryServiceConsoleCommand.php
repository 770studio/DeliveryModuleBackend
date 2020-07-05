<?php

namespace App\Console\Commands;

use App\GeoLocation;
use App\Http\Controllers\OrderDeliveryService;
use Illuminate\Console\Command;


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

         OrderDeliveryService::RunWithCron() ;







    }
}

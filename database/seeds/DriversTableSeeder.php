<?php

use Illuminate\Database\Seeder;
use App\Driver;


class DriversTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $d = Driver::create(['name' => 'Sushi Place', 'device_id' => '123 Main Street', 'blocked'=>0, 'available'=> 0  ]);
        $d2 = Driver::create(['name' => 'Burger Place', 'device_id' => '456 Other Street', 'blocked'=>0, 'available'=> 0]);

        $d->ping()->createMany([
                        ['lat' => 23, 'long' => 3.34],
                        ['lat' => 4323, 'long' => 4.45],
                  ]);

        $d2->ping()->createMany([
                       ['lat' => 'Barbecue Burger', 'long' => 5],
                      ['lat' => 'Slider', 'long' => 3],
                 ]);
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeliveryOrderTableAddMerchant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //merchant location

               Schema::table('deliveryorder', function(Blueprint $table)
               {

                   $table->decimal('delivery_lat', 20, 15)->default(0);
                   $table->decimal('delivery_long', 20, 15)->default(0);
                   $table->decimal('merchant_lat', 20, 15)->default(0);
                   $table->decimal('merchant_long', 20, 15)->default(0);



               });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

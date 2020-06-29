<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeliveryOrderTableAddRelatedGeo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


                Schema::table('deliveryorder', function (Blueprint $table) {
                    $table->string('geo_accuracy', 20 )->default('');
                    $table->string('formatted_address', 255 )->default('');
                    $table->integer('location_id')->unsigned()->index('location_id')->default(0);


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

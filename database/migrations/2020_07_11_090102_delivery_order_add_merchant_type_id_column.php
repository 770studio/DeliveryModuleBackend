<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeliveryOrderAddMerchantTypeIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 2) ;
            $table->string('description')->default('');
            $table->timestamps();
        });

        Schema::table('deliveryorder', function (Blueprint $table) {
            $table->string('merch_type', 2 ) ;
        });

        Schema::create('vehicle_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100 ) ;
            $table->string('description')->default('');
            $table->timestamps();
        });

        Schema::create('vehicle_preference', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100 )->default('') ;
            $table->string('description')->default('');
            $table->unsignedInteger('distance_id') ;
            $table->unsignedTinyInteger('index') ;
            $table->timestamps();
        });

        Schema::create('distances', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('from' )->comment('kilometers')  ;
            $table->unsignedInteger('to' ) ->comment('kilometers') ;
            $table->string('description')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchant_types');
        Schema::dropIfExists('vehicle_types');
        Schema::dropIfExists('vehicle_preference');
        Schema::dropIfExists('distances');

    }
}

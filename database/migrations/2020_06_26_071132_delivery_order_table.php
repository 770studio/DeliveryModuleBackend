<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeliveryOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveryorder', function(Blueprint $table)
        {
            $table->id('id');
            $table->integer('order_id')->index('order');
            $table->text('order_details')->nullable();
            $table->string('customer_delivery_address', 255);
            $table->string('customer_fullname', 255 )->nullable();
            $table->string('customer_phone_number', 25 )->nullable();
            $table->boolean('current_status')->default(0);

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
        //
    }
}

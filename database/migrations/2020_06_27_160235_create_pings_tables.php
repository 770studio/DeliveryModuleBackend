<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePingsTables extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pings_detailed', function(Blueprint $table)
		{
			$table->id('id');
            $table->unsignedInteger('driver_id')->index('driver');
            $table->decimal('lat', 20, 15)->default(0);
			$table->decimal('long', 20, 15)->default(0);
			$table->unsignedSmallInteger('count')->default(1);
			$table->boolean('order_status' )->unsigned()->default( 0 );
			$table->integer('order_id')->unsigned()->index('order');
            $table->timestamps();

        });

        Schema::create('pings', function(Blueprint $table)
        {
            $table->id('id');
             $table->unsignedInteger('driver_id')->unique('driver');
            $table->decimal('lat', 20, 15)->default(0);
            $table->decimal('long', 20, 15)->default(0);
            $table->unsignedSmallInteger('count')->default(1);
            $table->boolean('order_status' )->unsigned()->default( 0 );
            $table->integer('order_id')->unsigned()->index('order');
            $table->text('rejected_orders')->nullable();
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
		Schema::dropIfExists('pings_detailed');
		Schema::dropIfExists('pings');

	}
}

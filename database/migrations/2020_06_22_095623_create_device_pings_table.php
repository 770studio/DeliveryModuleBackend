<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicePingsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->dateTime('date');
			$table->unsignedInteger('driver_id')->unique('driver_id');
			$table->decimal('lat', 20, 15)->nullable();
			$table->decimal('long', 20, 15)->nullable();
			$table->unsignedSmallInteger('count')->default(1);
			$table->string('order_status', 25)->default('');
			$table->integer('order_id')->index('order');
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
		Schema::drop('pings');
	}
}

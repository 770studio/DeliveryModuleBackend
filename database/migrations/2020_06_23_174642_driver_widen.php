<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DriverWiden extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drivers', function(Blueprint $table)
        {
            $table->decimal('lat', 20, 15)->nullable()->default(null);
            $table->decimal('long', 20, 15)->nullable()->default(null);
            $table->unsignedSmallInteger('count')->default(1);
            $table->boolean('order_status')->nullable()->default(null);
            $table->integer('order_id')->index('order')->default(0);
            $table->text('rejected_orders')->nullable()->default(null);

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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PingsOrderIdDefaultVal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pings_detailed', function(Blueprint $table)
        {

            $table->integer('order_id')->default(0)->change();


        });

        Schema::table('pings', function(Blueprint $table)
        {

            $table->integer('order_id')->default(0)->change();


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

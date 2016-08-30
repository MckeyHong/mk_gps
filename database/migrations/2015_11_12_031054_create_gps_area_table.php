<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGpsAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gps_area', function (Blueprint $table) {
            $table->string('_id', 24)->unique();
            $table->string('city_name', 20);
            $table->string('blong_station', 20);
            $table->string('blong_araea', 20);
            $table->timestamp('create_date');
            $table->string('create_user');
            $table->timestamp('modify_date');
            $table->string('modify_user');
            //$table->primary(['city_name', 'blong_station', 'blong_araea']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('gps_area');
    }
}

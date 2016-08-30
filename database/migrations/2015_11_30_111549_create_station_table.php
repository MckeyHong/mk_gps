<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationTable extends Migration
{
    protected $table = 'station';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->string('_id', 24)->unique();
            $table->string('station_no', 20)->unique();
            $table->string('station_name', 50);
            $table->tinyInteger('station_status');
            $table->double('station_lat');
            $table->double('station_lng');
            $table->integer('total_space', 5);
            $table->integer('empty_space', 5);
            $table->integer('bike_station', 5);
            $table->integer('bike_breakdown', 5);
            $table->integer('bike_rope', 5);
            $table->timestamp('space_full_time');
            $table->timestamp('no_bike_time');
            $table->string('station_img', 20);
            $table->integer('set_rope', 5);
            $table->text('set_normalday');
            $table->text('set_weekday');
            $table->string('set_area', 10);
            $table->string('create_user');
            $table->timestamp('modify_date');
            $table->string('modify_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->table);
    }

}

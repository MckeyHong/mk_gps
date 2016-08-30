<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_type', function (Blueprint $table) {
            $table->string('_id', 24)->unique();
            $table->string('car_type', 20)->unique();
            $table->timestamp('create_date');
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
        Schema::drop('car_type');
    }
}

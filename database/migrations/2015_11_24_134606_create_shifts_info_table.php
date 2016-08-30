<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftsInfoTable extends Migration
{
    protected $table = 'shifts_info';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->string('_id', 24)->unique();
            $table->string('shift_name', 10)->unique();
            $table->string('shift_start_time', 10);
            $table->string('shift_end_time', 10);
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
        Schema::drop($this->table);
    }

}

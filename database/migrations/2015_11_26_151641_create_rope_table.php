<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRopeTable extends Migration
{
    protected $table = 'rope';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->string('_id', 24)->unique();
            $table->string('city', 20);
            $table->string('rope_no', 20)->unique();
            $table->tinyInteger('rope_status', 1)->unsigned()->default(1);
            $table->text('staff_info');
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

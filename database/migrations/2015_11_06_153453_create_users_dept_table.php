<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersDeptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_dept', function (Blueprint $table) {
            $table->string('_id', 24)->unique();
            $table->string('city', 20);
            $table->Integer('level', 5)->unsigned();
            $table->Integer('sort', 5)->unsigned()->default(99);
            $table->string('parent_id', 24)->index();
            $table->text('parent_arr');
            $table->string('dept_name', 30);
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
        Schema::drop('users_dept');
    }
}

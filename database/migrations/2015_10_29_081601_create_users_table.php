<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('_id', 24)->unique();
            $table->string('username', 20)->unique();
            $table->string('password', 60);
            $table->tinyInteger('enable_type', 1)->unsigned()->default(1);
            $table->string('users_name', 20);
            $table->string('role_id', 24)->index();
            $table->string('dept_id', 24)->index();
            $table->text('city');
            $table->string('work_notice', 100);
            $table->text('work_keynote');
            $table->string('api_key', 100)->unique();
            $table->timestamp('create_date');
            $table->string('create_user');
            $table->timestamp('modify_date');
            $table->string('modify_user');
            $table->rememberToken();
            $table->index(['username', 'password']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}

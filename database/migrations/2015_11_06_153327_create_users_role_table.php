<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_role', function (Blueprint $table) {
            $table->string('_id', 24)->unique();
            $table->string('role_name', 20)->unique();
            $table->text('role_privilege');
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
        Schema::drop('users_role');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordLoginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_login', function (Blueprint $table) {
            $table->string('_id', 24)->unique();
            $table->string('login_username', 20);
            $table->tinyInteger('login_type', 1)->unsigned()->default(1);
            $table->string('login_ip', 50);
            $table->timestamp('create_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('record_login');
    }
}

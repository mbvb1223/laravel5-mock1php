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
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('yourname');
            $table->string('password', 60);
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('avatar');
            $table->string('status');
            $table->string('keyactive');
            $table->integer('role_id');
            $table->string('address');
            $table->integer('city_id');
            $table->integer('region_id');
            $table->rememberToken();
            $table->timestamps();
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

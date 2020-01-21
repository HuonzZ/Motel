<?php

use Illuminate\Support\Facades\Schema;
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
            $table->string('name');
            $table->string('username');
            $table->string('avatar')->default('no-avatar.jpg');

            $table->date('dateofbrith')->nullable(); //Ngày tháng và năm sinh
            $table->tinyInteger('gender')->nullable(); //Giới tính
            $table->string('address')->nullable(); //Hộ khẩu thường trú

            $table->string('phone')->nullable();
            $table->string('email');
            $table->string('password');

            $table->integer('tinhtrang')->default(1);
            $table->integer('right')->default(0);

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
        Schema::dropIfExists('users');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMotelRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motelrooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->string('address');
            $table->integer('area');
            $table->string('utilities');
            $table->integer('price');

            $table->string('latlng');
            $table->string('images');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('user1_id')->unsigned()->nullable();
            $table->integer('category_id');
            $table->integer('district_id');

            $table->string('phone');
            $table->integer('count_view');
            $table->integer('roomstatus');
            $table->integer('approve')->default(0);

            $table->date('startday')->nullable();
            $table->date('endday')->nullable();
            $table->integer('number')->nullable();
            $table->string('check')->nullable();

            $table->foreign('user_id')
                ->references('id')->on('users');

            $table->foreign('user1_id')
                ->references('id')->on('users');

            $table->string('slug');


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
        Schema::dropIfExists('motelrooms');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookrooms',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('id_user')->unsigned();
                $table->integer('id_motelroom')->unsigned();
                $table->date('startday')->nullable();
                $table->date('endday')->nullable();
                $table->integer('number')->nullable();
                $table->string('check')->nullable();

//                $table->integer('id_user')->unsigned()->change();
                $table->foreign('id_user')
                    ->references('id')->on('users');

//                $table->integer('id_motelroom')->unsigned()->change();
                $table->foreign('id_motelroom')
                    ->references('id')->on('motelrooms');

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
        Schema::dropIfExists('bookrooms');
    }
}

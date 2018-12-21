<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GO extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('g_o', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_game');
            $table->unsignedInteger('id_option');
            $table->string('value', 255);

            $table->foreign('id_game')->references('id')->on('game');
            $table->foreign('id_option')->references('id')->on('options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('g_o');
    }
}

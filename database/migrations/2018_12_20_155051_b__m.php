<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BM extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards_modules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_board');
            $table->unsignedInteger('id_module');

            $table->foreign('id_board')->references('id')->on('boards');
            $table->foreign('id_module')->references('id')->on('modules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boards_modules');
    }
}

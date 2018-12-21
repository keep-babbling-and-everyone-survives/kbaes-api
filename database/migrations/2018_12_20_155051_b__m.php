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
        Schema::create('B_M', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_board');
            $table->unsignedInteger('id_module');

            $table->foreign('id_board')->references('id')->on('Board');
            $table->foreign('id_module')->references('id')->on('Module');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('B_M');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MCCSG extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_cc_s_g', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_m_cc_s');
            $table->unsignedInteger('id_game');
            $table->tinyInteger('solved');
            $table->tinyInteger('correct');

            $table->foreign('id_m_cc_s')->references('id')->on('m_cc_s');
            $table->foreign('id_game')->references('id')->on('game');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_cc_s_g');
    }
}

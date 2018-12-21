<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GRS extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('G_RS', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_game');
            $table->unsignedInteger('id_rule_set');

            $table->foreign('id_game')->references('id')->on('Game');
            $table->foreign('id_rule_set')->references('id')->on('Rule_Set');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('G_RS');
    }
}

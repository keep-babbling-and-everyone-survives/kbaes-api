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
        Schema::create('g_rs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_game');
            $table->unsignedInteger('id_rule_set');

            $table->foreign('id_game')->references('id')->on('game');
            $table->foreign('id_rule_set')->references('id')->on('rule_set');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('g_rs');
    }
}

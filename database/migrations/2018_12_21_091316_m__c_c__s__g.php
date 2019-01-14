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
        Schema::create('modules_rule_sets_solutions_games', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_m_cc_s');
            $table->unsignedInteger('id_game');
            $table->tinyInteger('solved');
            $table->tinyInteger('correct');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules_rule_sets_solutions_games');
    }
}

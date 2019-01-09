<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RuleSetGame extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('games_rule_sets');
        Schema::rename('modules_rule_sets_solutions_games', 'games_rule_sets');
        Schema::table('games_rule_sets', function($table) {
            $table->renameColumn('id_m_cc_s', 'id_rule_set');
            
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games_rule_sets', function (Blueprint $table) {
            $table->renameColumn('id_rule_set', 'id_m_cc_s');
        });
        Schema::rename('games_rule_sets', 'modules_rule_sets_solutions_games');
        Schema::create('games_rule_sets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_game');
            $table->unsignedInteger('id_rule_set');

            $table->foreign('id_game')->references('id')->on('games');
            $table->foreign('id_rule_set')->references('id')->on('rule_sets');

        });
    }
}

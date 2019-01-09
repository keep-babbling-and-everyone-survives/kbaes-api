<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MCCS extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules_rule_sets_solutions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_module');
            $table->unsignedInteger('id_solution');
            $table->unsignedInteger('id_rule_set');

            $table->foreign('id_module')->references('id')->on('modules');
            $table->foreign('id_solution')->references('id')->on('solutions');
            $table->foreign('id_rule_set')->references('id')->on('rule_sets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules_rule_sets_solutions');
    }
}

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
        Schema::create('m_cc_s', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_module');
            $table->unsignedInteger('id_solution');
            $table->unsignedInteger('id_rule_set');

            $table->foreign('id_module')->references('id')->on('module');
            $table->foreign('id_solution')->references('id')->on('solution');
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
        Schema::dropIfExists('m_cc_s');
    }
}

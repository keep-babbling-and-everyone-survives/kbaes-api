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
        Schema::create('M_CC_S', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('id_module');
            $table->unsignedInteger('id_solution');
            $table->unsignedInteger('id_rule_set');

            $table->foreign('id_module')->references('id')->on('Module');
            $table->foreign('id_solution')->references('id')->on('Solution');
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
        Schema::dropIfExists('M_CC_S');
    }
}

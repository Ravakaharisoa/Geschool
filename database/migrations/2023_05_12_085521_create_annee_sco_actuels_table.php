<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnneeScoActuelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annee_sco_actuels', function (Blueprint $table) {
            $table->id();
            $table->foreignId("annee_scolaire_id")->constrained();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('annee_sco_actuels', function(Blueprint $table){
            $table->dropForeign('annee_scolaire_id');
        });
        Schema::dropIfExists('annee_sco_actuels');
    }
}

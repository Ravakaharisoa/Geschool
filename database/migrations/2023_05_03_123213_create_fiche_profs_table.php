<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFicheProfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiche_profs', function (Blueprint $table) {
            $table->id();
            $table->date('date_presence')->nullable();
            $table->time('debut')->nullable();
            $table->time('fin')->nullable();
            $table->boolean('status')->nullable()->default(1);
            $table->foreignId("professeur_id")->constrained();
            $table->foreignId("annee_scolaire_id")->constrained();
            $table->timestamps();
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
        Schema::table('fiche_profs', function(Blueprint $table){
            $table->dropForeign(['professeur_id','annee_scolaire_id']);
        });
        Schema::dropIfExists('fiche_profs');
    }
}

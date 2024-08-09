<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->string('jour')->nullable();
            $table->integer('numero_jour')->length(1)->default(0);
            $table->foreignId("classe_id")->constrained();
            $table->foreignId("matiere_id")->constrained();
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
        Schema::table('users', function(Blueprint $table){
            $table->dropForeign(['professeur_id','classe_id','matiere_id','annee_scolaire_id']);
        });
        Schema::dropIfExists('cours');
    }
}

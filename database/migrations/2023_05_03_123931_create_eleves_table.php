<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElevesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eleves', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('email');
            $table->string('matricule');
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('sexe');
            $table->string('adresse')->nullable();
            $table->string('nationalite')->nullable();
            $table->string('contact_prim');
            $table->string('nom_pere')->nullable();
            $table->string('nom_mere')->nullable();
            $table->string('maladie')->nullable();
            $table->date('date_inscription')->nullable();
            $table->string('contact_seco')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('actif')->nullable()->default(1);
            $table->foreignId("user_id")->constrained();
            $table->foreignId("classe_id")->constrained();
            $table->foreignId("annee_scolaire_id")->constrained();
            $table->string('observation')->nullable();
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
        Schema::table('eleves', function(Blueprint $table){
            $table->dropForeign(['classe_id','user_id','annee_scolaire_id']);
        });
        Schema::dropIfExists('eleves');
    }
}

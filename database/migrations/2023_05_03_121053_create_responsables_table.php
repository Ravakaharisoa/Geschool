<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsables', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('email');
            $table->string('fonction');
            $table->string('matricule');
            $table->string('sexe');
            $table->string('adresse')->nullable();
            $table->string('cin')->nullable();
            $table->string('nationalite')->nullable();
            $table->string('contact_prim');
            $table->string('contact_seco')->nullable();
            $table->string('photo')->nullable();
            $table->string('type_contrat')->nullable();
            $table->date('date_embauche')->nullable();
            $table->boolean('actif')->nullable()->default(1);
            $table->foreignId("user_id")->constrained();
            $table->foreignId("ecole_id")->constrained();
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
        Schema::table('responsables', function(Blueprint $table){
            $table->dropForeign(['user_id','ecole_id']);
        });
        Schema::dropIfExists('responsables');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfesseursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professeurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('matricule');
            $table->string('email');
            $table->string('nationalite')->nullable();
            $table->string('sexe');
            $table->string('adresse')->nullable();
            $table->string('cin')->nullable();
            $table->string('contact1');
            $table->string('contact2')->nullable();
            $table->string('image')->nullable();
            $table->string('type_contrat')->nullable();
            $table->date('date_embauche')->nullable();
            $table->boolean('actif')->nullable()->default(1);
            $table->foreignId("user_id")->constrained();
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
        Schema::table('professeurs', function(Blueprint $table){
            $table->dropForeign('user_id');
        });
        Schema::dropIfExists('professeurs');
    }
}

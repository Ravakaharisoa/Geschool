<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbscencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abscences', function (Blueprint $table) {
            $table->id();
            $table->date('date_absence')->nullable();
            $table->string('motif')->nullable();
            $table->foreignId("eleve_id")->constrained();
            $table->foreignId("cour_id")->constrained();
            $table->string('billet_entrer')->nullable();
            $table->string('piece_justification')->nullable();
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
        Schema::table('abscences', function(Blueprint $table){
            $table->dropForeign(['eleve_id','cour_id']);
        });
        Schema::dropIfExists('abscences');
    }
}

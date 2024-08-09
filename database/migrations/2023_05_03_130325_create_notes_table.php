<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->date('date_evaluation')->nullable();
            $table->integer('coefficient')->length(2)->default(1);
            $table->decimal('note', 15, 2);
            $table->foreignId("eleve_id")->constrained();
            $table->foreignId("module_id")->constrained();
            $table->foreignId("matiere_id")->constrained();
            $table->foreignId("type_examen_id")->constrained();
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
        Schema::table('notes', function(Blueprint $table){
            $table->dropForeign(['eleve_id','module_id','matiere_id','type_examen_id']);
        });
        Schema::dropIfExists('notes');
    }
}

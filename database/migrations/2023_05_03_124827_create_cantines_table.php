<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCantinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cantines', function (Blueprint $table) {
            $table->id();
            $table->date('date_cantine')->nullable();
            $table->date('date_paye')->nullable();
            $table->decimal('montant', 15, 2);
            $table->foreignId("eleve_id")->constrained();
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
        Schema::table('cantines', function(Blueprint $table){
            $table->dropForeign('eleve_id');
        });
        Schema::dropIfExists('cantines');
    }
}

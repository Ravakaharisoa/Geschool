<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transports', function (Blueprint $table) {
            $table->id();
            $table->string('mois')->nullable();
            $table->decimal('montant', 15, 2);
            $table->date('date_payement')->nullable();
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
        Schema::table('transports', function(Blueprint $table){
            $table->dropForeign('eleve_id');
        });
        Schema::dropIfExists('transports');
    }
}

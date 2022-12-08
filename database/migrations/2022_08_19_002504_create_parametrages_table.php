<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametrages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numLot');
            $table->string('numCommande');
            $table->string('numFacture');
            $table->string('numVente');
            $table->string('numInventaire');
            $table->string('numMedicament');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parametrages');
    }
};

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
        Schema::create('details_factures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('factures_id')->unsigned();
            $table->foreign('factures_id')->references('id')->on('factures');
            $table->integer('lots_id')->unsigned();
            $table->foreign('lots_id')->references('id')->on('lots');
            $table->integer('qteAchetee');
            $table->float('montant');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('details_factures');
    }
};
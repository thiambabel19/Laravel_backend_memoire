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
        Schema::create('details_inventaires', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventaires_id')->unsigned();
            $table->foreign('inventaires_id')->references('id')->on('inventaires');
            $table->integer('lots_id')->unsigned();
            $table->foreign('lots_id')->references('id')->on('lots');
            $table->string('periode');
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
        Schema::dropIfExists('details_inventaires');
    }
};
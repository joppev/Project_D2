<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plannings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gebruikerID');
            $table->foreignId('kadeID');
            $table->foreignId('tijdTabelID');
            $table->string('proces');
            $table->string('ladingDetails');
            $table->string('aantal');
            $table->boolean('isAanwezig');
            $table->boolean('isAfgewerkt');
            $table->timestamps();

            $table->foreign('gebruikerID')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kadeID')->references('id')->on('kades')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tijdTabelID')->references('id')->on('tijd_tabels')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plannings');
    }
}

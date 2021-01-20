<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('statusID');
            $table->string('naam');
            $table->string('land');
            $table->string('gemeente');
            $table->string('adres');
            $table->string('latitude');
            $table->string('longitude');
            $table->timestamps();

            $table->foreign('statusID')->references('id')->on('statuses')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kades');
    }
}

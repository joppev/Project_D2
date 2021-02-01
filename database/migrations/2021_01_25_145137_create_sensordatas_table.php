<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensordatasTable extends Migration
{
    /**
     * Run the migrations.
    *
     * @return void
     */
    public function up()
    {
        Schema::create('sensordatas', function (Blueprint $table) {
            $table->string('kadeNaam');
            $table->integer('afstand');
            $table->boolean('kadeVrij');
            $table->timestamp('tijdstip');
        });
        DB::table('sensordatas')->insert(
            []);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sensordatas');
    }
}

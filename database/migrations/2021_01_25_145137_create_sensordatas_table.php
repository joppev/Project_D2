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
            $table->bigIncrements('id');
            $table->integer('afstand1');
            $table->integer('afstand2');
            $table->boolean('kade1');
            $table->boolean('kade2');
            $table->timestamp('tijdstip');
            $table->timestamps();
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

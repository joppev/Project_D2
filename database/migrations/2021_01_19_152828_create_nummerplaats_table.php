<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNummerplaatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nummerplaats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bedrijfID');
            $table->string('plaatcombinatie');
            $table->timestamps();

            $table->foreign('bedrijfID')->references('id')->on('bedrijfs')->onDelete('cascade')->onUpdate('cascade');

        });
        DB::table('nummerplaats')->insert(
            [
                [
                    'bedrijfID' => 1,
                    'plaatscombinatie' => "plaatscombinatie1",
                ],
                [
                'bedrijfID' => 2,
                'plaatscombinatie' => "plaatscombinatie2",
            ],
                [
                    'bedrijfID' => 3,
                    'plaatscombinatie' => "plaatscombinatie3",
                ]
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nummerplaats');
    }
}

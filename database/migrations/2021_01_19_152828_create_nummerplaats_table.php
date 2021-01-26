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
                    'plaatcombinatie' => "1-ABC-123",
                ],
                [
                    'bedrijfID' => 2,
                    'plaatcombinatie' => "1-DEF-456",
                ],
                [
                    'bedrijfID' => 3,
                    'plaatcombinatie' => "1-GHI-789",
                ],
                [
                    'bedrijfID' => 4,
                    'plaatcombinatie' => "1-JKL-123",
                ],
                [
                    'bedrijfID' => 4,
                    'plaatcombinatie' => "1-MNO-456",
                ],
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

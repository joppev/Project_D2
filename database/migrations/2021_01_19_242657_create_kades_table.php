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
        DB::table('kades')->insert(
            [
                [
                'statusID' => 1,
                'naam' => "kade1",
                'land' => "België",
                'gemeente' => "Geel",
                'adres' => "Larumseweg 90",
                'latitude' => "51,15",
                'longitude' => "80,10",
            ],
                [
                    'statusID' => 2,
                    'naam' => "kade2",
                    'land' => "België",
                    'gemeente' => "Geel",
                    'adres' => "Larumseweg 90",
                    'latitude' => "55,15",
                    'longitude' => "90,20",
                ],
                [
                    'statusID' => 3,
                    'naam' => "kade3",
                    'land' => "België",
                    'gemeente' => "Geel",
                    'adres' => "Larumseweg 90",
                    'latitude' => "50,15",
                    'longitude' => "75,20",
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
        Schema::dropIfExists('kades');
    }
}

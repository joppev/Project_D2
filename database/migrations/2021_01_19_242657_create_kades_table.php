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
            $table->string('kadenaam');
            $table->string('land');
            $table->string('gemeente');
            $table->string('adres');
            $table->float('latitude');
            $table->float('longitude');
            $table->string('status');
            $table->timestamps();


        });
        DB::table('kades')->insert(
            [
                [
                'kadenaam' => "Kade 1",
                'land' => "België",
                'gemeente' => "Geel",
                'adres' => "Larumseweg 90",
                'latitude' => 51.16,
                'longitude' => 4.96,
                'status' => 'Vrij',
            ],
                [

                    'kadenaam' => "Kade 2",
                    'land' => "België",
                    'gemeente' => "Geel",
                    'adres' => "Larumseweg 90",
                    'latitude' => 51.16,
                    'longitude' => 4.96,
                    'status' => 'Buiten gebruik'
                ],
                [
                    'kadenaam' => "Kade 3",
                    'land' => "België",
                    'gemeente' => "Geel",
                    'adres' => "Larumseweg 90",
                    'latitude' => 51.16,
                    'longitude' => 4.96,
                    'status' => 'Vrij',
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

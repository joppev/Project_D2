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
            $table->string('naam');
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
                'naam' => "kade1",
                'land' => "België",
                'gemeente' => "Geel",
                'adres' => "Larumseweg 90",
                'latitude' => 51.15,
                'longitude' => 80.10,
                'status' => 'Vrij',
            ],
                [

                    'naam' => "kade2",
                    'land' => "België",
                    'gemeente' => "Geel",
                    'adres' => "Larumseweg 90",
                    'latitude' => 55.15,
                    'longitude' => 90.20,
                    'status' => 'Buiten gebruik'
                ],
                [
                    'naam' => "kade3",
                    'land' => "België",
                    'gemeente' => "Geel",
                    'adres' => "Larumseweg 90",
                    'latitude' => 50.15,
                    'longitude' => 75.20,
                    'status' => 'Niet-vrij',
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBedrijfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bedrijfs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bedrijfsnaam');
            $table->string('standaardWachtwoord');
            $table->timestamps();
        });
        DB::table('bedrijfs')->insert(
            [
                [
                    'bedrijfsnaam' => 'Apple',
                    'standaardWachtwoord'  =>'apple1234',
                    'created_at' => now(),
                    'updated_at'=> now()

                ],
                [
                    'bedrijfsnaam' => 'Samsung',
                    'standaardWachtwoord'  =>'samsung1234',
                    'created_at' => now(),
                    'updated_at'=> now()
                ],
                [
                    'bedrijfsnaam' => 'Aldi',
                    'standaardWachtwoord'  =>'aldi1234',
                    'created_at' => now(),
                    'updated_at'=> now()
                ],
                [
                    'bedrijfsnaam' => 'Dopper',
                    'standaardWachtwoord'  =>'dopper1234',
                    'created_at' => now(),
                    'updated_at'=> now()
                ],

            ]
        );}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bedrijfs');
    }
}

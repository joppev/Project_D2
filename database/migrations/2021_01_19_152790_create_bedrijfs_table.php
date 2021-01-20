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
            $table->id();
            $table->string('bedrijfsnaam');
            $table->string('standaardWachtwoord');
            $table->timestamps();
        });
        DB::table('bedrijfs')->insert(
            [
                [
                    'bedrijfsnaam' => 'Apple',
                    'standaardWachtwoord'  =>'apple123'

                ],
                [
                    'bedrijfsnaam' => 'Samsung',
                    'standaardWachtwoord'  =>'samsung123'
                ],
                [
                    'bedrijfsnaam' => 'Aldi',
                    'standaardWachtwoord'  =>'aldi123'
                ],
                [
                    'bedrijfsnaam' => 'Dopper',
                    'standaardWachtwoord'  =>'dopper123'
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

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
            $table->string('naam');
            $table->string('standaardWachtwoord');
            $table->timestamps();
        });
        DB::table('tijd_tabels')->insert(
            [
                [
                    'naam' => 'apple',
                    'standaardWachtwoord'  =>'apple123'

                ],
                [
                    'naam' => 'samsung',
                    'standaardWachtwoord'  =>'samsung123'
                ],
                [
                    'naam' => 'aldi',
                    'standaardWachtwoord'  =>'aldi123'
                ],
                [
                    'naam' => 'dopper',
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

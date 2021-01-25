<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plannings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gebruikerID');
            $table->foreignId('kadeID');
            $table->foreignId('tijdTabelID');
            $table->string('proces');
            $table->string('ladingDetails');
            $table->integer('aantal');
            $table->boolean('isAanwezig');
            $table->boolean('isBezig');
            $table->boolean('isAfgewerkt');
            $table->timestamps();

            $table->foreign('gebruikerID')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kadeID')->references('id')->on('kades')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tijdTabelID')->references('id')->on('tijd_tabels')->onDelete('cascade')->onUpdate('cascade');

        });
        DB::table('plannings')->insert(
            [
                [
                    'gebruikerID' => 1,
                    'kadeID' => 1,
                    'tijdTabelID' => 1,
                    'proces' => "proces1",
                    'ladingDetails' => "ladingDetails1",
                    'aantal' => 2,
                    'isAanwezig' => true,
                    'isBezig' => true,
                    'isAfgewerkt' => false,
                    'created_at' => now(),
                    'updated_at'=> now()
                ],
                [
                    'gebruikerID' => 2,
                    'kadeID' => 2,
                    'tijdTabelID' => 2,
                    'proces' => "proces2",
                    'ladingDetails' => "ladingDetails2",
                    'aantal' => 3,
                    'isAanwezig' => false,
                    'isBezig' => false,
                    'isAfgewerkt' => false,
                    'created_at' => now(),
                    'updated_at'=> now()
                ],
                [
                    'gebruikerID' => 1,
                    'kadeID' => 3,
                    'tijdTabelID' => 6,
                    'proces' => "proces3",
                    'ladingDetails' => "ladingDetails3",
                    'aantal' => 3,
                    'isAanwezig' => true,
                    'isBezig' => false,
                    'isAfgewerkt' => true,
                    'created_at' => now(),
                    'updated_at'=> now()
                ],
                [
                    'gebruikerID' => 3,
                    'kadeID' => 3,
                    'tijdTabelID' => 4,
                    'proces' => "proces3",
                    'ladingDetails' => "ladingDetails3",
                    'aantal' => 3,
                    'isAanwezig' => true,
                    'isBezig' => false,
                    'isAfgewerkt' => false,
                    'created_at' => now(),
                    'updated_at'=> now()
                ],

                [
                    'gebruikerID' => 3,
                    'kadeID' => 1,
                    'tijdTabelID' => 4,
                    'proces' => "proces3",
                    'ladingDetails' => "ladingDetails3",
                    'aantal' => 3,
                    'isAanwezig' => true,
                    'isBezig' => true,
                    'isAfgewerkt' => false,
                    'created_at' => now(),
                    'updated_at'=> now()
                ],
                [
                    'gebruikerID' => 3,
                    'kadeID' => 3,
                    'tijdTabelID' => 5,
                    'proces' => "proces3",
                    'ladingDetails' => "ladingDetails3",
                    'aantal' => 3,
                    'isAanwezig' => true,
                    'isBezig' => false,
                    'isAfgewerkt' => true,
                    'created_at' => now(),
                    'updated_at'=> now()
                ],
                [
                    'gebruikerID' => 3,
                    'kadeID' => 3,
                    'tijdTabelID' => 5,
                    'proces' => "proces3",
                    'ladingDetails' => "ladingDetails3",
                    'aantal' => 3,
                    'isAanwezig' => true,
                    'isBezig' => false,
                    'isAfgewerkt' => true,
                    'created_at' => now(),
                    'updated_at'=> now()
                ],
                [
                    'gebruikerID' => 3,
                    'kadeID' => 3,
                    'tijdTabelID' => 6,
                    'proces' => "proces3",
                    'ladingDetails' => "ladingDetails3",
                    'aantal' => 3,
                    'isAanwezig' => true,
                    'isBezig' => true,
                    'isAfgewerkt' => false,
                    'created_at' => now(),
                    'updated_at'=> now()
                ],[
                'gebruikerID' => 3,
                'kadeID' => 2,
                'tijdTabelID' => 6,
                'proces' => "proces3",
                'ladingDetails' => "ladingDetails3",
                'aantal' => 3,
                'isAanwezig' => true,
                'isBezig' => false,
                'isAfgewerkt' => false,
                'created_at' => now(),
                'updated_at'=> now()
            ],

            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plannings');
    }
}

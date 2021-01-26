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
            $table->string('proces');
            $table->string('ladingDetails');
            $table->integer('aantal');
            $table->boolean('isAanwezig');
            $table->boolean('isBezig');
            $table->boolean('isAfgewerkt');
            $table->dateTime('startTijd');
            $table->dateTime('stopTijd');
            $table->timestamps();

            $table->foreign('gebruikerID')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kadeID')->references('id')->on('kades')->onDelete('cascade')->onUpdate('cascade');

        });
        DB::table('plannings')->insert(
            [
                [
                    'gebruikerID' => 1,
                    'kadeID' => 1,
                    'proces' => "Laden",
                    'ladingDetails' => "ladingDetails1",
                    'aantal' => 2,
                    'isAanwezig' => true,
                    'isBezig' => true,
                    'isAfgewerkt' => false,
                    'startTijd' => DateTime::createFromFormat('Y-m-d H:i','2021-01-22 12:30'),
                    'stopTijd'  => DateTime::createFromFormat('Y-m-d H:i','2021-01-22 13:00'),
                    'created_at' => now(),
                    'updated_at'=> now()
                ],
                [
                    'gebruikerID' => 2,
                    'kadeID' => 2,
                    'proces' => "Lossen",
                    'ladingDetails' => "ladingDetails2",
                    'aantal' => 3,
                    'isAanwezig' => false,
                    'isBezig' => false,
                    'isAfgewerkt' => false,
                    'startTijd' => DateTime::createFromFormat('Y-m-d H:i','2021-01-21 9:00'),
                    'stopTijd'  =>DateTime::createFromFormat('Y-m-d H:i','2021-01-21 9:30'),
                    'created_at' => now(),
                    'updated_at'=> now()
                ],
                [
                    'gebruikerID' => 1,
                    'kadeID' => 3,
                    'proces' => "Laden",
                    'ladingDetails' => "ladingDetails3",
                    'aantal' => 3,
                    'isAanwezig' => true,
                    'isBezig' => false,
                    'isAfgewerkt' => true,
                    'startTijd' => DateTime::createFromFormat('Y-m-d H:i','2021-01-26 15:30'),
                    'stopTijd'  =>DateTime::createFromFormat('Y-m-d H:i','2021-01-26 16:00'),
                    'created_at' => now(),
                    'updated_at'=> now()
                ],
                [
                    'gebruikerID' => 3,
                    'kadeID' => 3,
                    'proces' => "Check-up",
                    'ladingDetails' => "ladingDetails3",
                    'aantal' => 3,
                    'isAanwezig' => true,
                    'isBezig' => false,
                    'isAfgewerkt' => false,
                    'startTijd' => DateTime::createFromFormat('Y-m-d H:i','2021-01-26 15:30'),
                    'stopTijd'  =>DateTime::createFromFormat('Y-m-d H:i','2021-01-26 16:00'),

                    'created_at' => now(),
                    'updated_at'=> now()
                ],

                [
                    'gebruikerID' => 3,
                    'kadeID' => 1,
                    'proces' => "Lossen",
                    'ladingDetails' => "ladingDetails3",
                    'aantal' => 3,
                    'isAanwezig' => true,
                    'isBezig' => true,
                    'isAfgewerkt' => false,
                    'startTijd' => DateTime::createFromFormat('Y-m-d H:i','2021-01-26 15:30'),
                    'stopTijd'  =>DateTime::createFromFormat('Y-m-d H:i','2021-01-26 16:00'),

                    'created_at' => now(),
                    'updated_at'=> now()
                ],
                [
                    'gebruikerID' => 3,
                    'kadeID' => 3,
                    'proces' => "Lossen",
                    'ladingDetails' => "ladingDetails3",
                    'aantal' => 3,
                    'isAanwezig' => true,
                    'isBezig' => false,
                    'isAfgewerkt' => true,
                    'startTijd' => DateTime::createFromFormat('Y-m-d H:i','2021-01-26 15:30'),
                    'stopTijd'  =>DateTime::createFromFormat('Y-m-d H:i','2021-01-26 16:00'),
                    'created_at' => now(),
                    'updated_at'=> now()
                ],
                [
                    'gebruikerID' => 3,
                    'kadeID' => 3,
                    'proces' => "Lossen",
                    'ladingDetails' => "ladingDetails3",
                    'aantal' => 3,
                    'isAanwezig' => true,
                    'isBezig' => false,
                    'isAfgewerkt' => true,
                    'startTijd' => DateTime::createFromFormat('Y-m-d H:i','2021-01-26 15:30'),
                    'stopTijd'  =>DateTime::createFromFormat('Y-m-d H:i','2021-01-26 16:00'),

                    'created_at' => now(),
                    'updated_at'=> now()
                ],
                [
                    'gebruikerID' => 3,
                    'kadeID' => 3,
                    'proces' => "Laden",
                    'ladingDetails' => "ladingDetails3",
                    'aantal' => 3,
                    'isAanwezig' => true,
                    'isBezig' => true,
                    'isAfgewerkt' => false,
                    'startTijd' => DateTime::createFromFormat('Y-m-d H:i','2021-01-26 15:30'),
                    'stopTijd'  =>DateTime::createFromFormat('Y-m-d H:i','2021-01-26 16:00'),

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

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
            $table->foreignId('soort_id');
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
            $table->foreign('soort_id')->references('id')->on('soorts')->onDelete('cascade')->onUpdate('cascade');
        });
        DB::table('plannings')->insert(
            [
                [
                    'gebruikerID' => 1,
                    'kadeID' => 1,
                    'soort_id' => 1,
                    'ladingDetails' => "ladingDetails1",
                    'aantal' => 2,
                    'isAanwezig' => true,
                    'isBezig' => true,
                    'isAfgewerkt' => false,
                    'startTijd' => DateTime::createFromFormat('Y-m-d H:i','2021-02-03 13:00'),
                    'stopTijd'  => DateTime::createFromFormat('Y-m-d H:i','2021-02-03 14:00'),
                    'created_at' => now(),
                    'updated_at'=> now()
                ],
                [
                    'gebruikerID' => 3,
                    'kadeID' => 2,
                    'soort_id' => 2,
                    'ladingDetails' => "ladingDetails2",
                    'aantal' => 3,
                    'isAanwezig' => false,
                    'isBezig' => false,
                    'isAfgewerkt' => false,
                    'startTijd' => DateTime::createFromFormat('Y-m-d H:i','2021-02-03 11:00'),
                    'stopTijd'  =>DateTime::createFromFormat('Y-m-d H:i','2021-02-03 12:30'),
                    'created_at' => now(),
                    'updated_at'=> now()
                ],
                [
                    'gebruikerID' => 1,
                    'kadeID' => 3,
                    'soort_id' => 3,
                    'ladingDetails' => "ladingDetails3",
                    'aantal' => 3,
                    'isAanwezig' => false,
                    'isBezig' => false,
                    'isAfgewerkt' => false,
                    'startTijd' => DateTime::createFromFormat('Y-m-d H:i','2021-02-03 12:00'),
                    'stopTijd'  =>DateTime::createFromFormat('Y-m-d H:i','2021-02-03 13:00'),
                    'created_at' => now(),
                    'updated_at'=> now()
                ],
                [
                    'gebruikerID' => 3,
                    'kadeID' => 4,
                    'soort_id' => 2,
                    'ladingDetails' => "ladingDetails3",
                    'aantal' => 3,
                    'isAanwezig' => false,
                    'isBezig' => false,
                    'isAfgewerkt' => false,
                    'startTijd' => DateTime::createFromFormat('Y-m-d H:i','2021-02-03 12:00'),
                    'stopTijd'  =>DateTime::createFromFormat('Y-m-d H:i','2021-02-03 13:00'),
                    'created_at' => now(),
                    'updated_at'=> now()
                ],

                [
                    'gebruikerID' => 3,
                    'kadeID' => 1,
                    'soort_id' => 1,
                    'ladingDetails' => "ladingDetails3",
                    'aantal' => 3,
                    'isAanwezig' => false,
                    'isBezig' => false,
                    'isAfgewerkt' => false,
                    'startTijd' => DateTime::createFromFormat('Y-m-d H:i','2021-02-02 10:00'),
                    'stopTijd'  =>DateTime::createFromFormat('Y-m-d H:i','2021-02-02 11:00'),

                    'created_at' => now(),
                    'updated_at'=> now()
                ],
                [
                    'gebruikerID' => 3,
                    'kadeID' => 5,
                    'soort_id' => 1,
                    'ladingDetails' => "ladingDetails3",
                    'aantal' => 3,
                    'isAanwezig' => false,
                    'isBezig' => false,
                    'isAfgewerkt' => false,
                    'startTijd' => DateTime::createFromFormat('Y-m-d H:i','2021-02-02 14:00'),
                    'stopTijd'  =>DateTime::createFromFormat('Y-m-d H:i','2021-02-02 15:00'),
                    'created_at' => now(),
                    'updated_at'=> now()
                ],
                [
                    'gebruikerID' => 1,
                    'kadeID' => 6,
                    'soort_id' => 1,
                    'ladingDetails' => "ladingDetails3",
                    'aantal' => 3,
                    'isAanwezig' => false,
                    'isBezig' => false,
                    'isAfgewerkt' => false,
                    'startTijd' => DateTime::createFromFormat('Y-m-d H:i','2021-02-02 14:00'),
                    'stopTijd'  =>DateTime::createFromFormat('Y-m-d H:i','2021-02-02 15:00'),

                    'created_at' => now(),
                    'updated_at'=> now()
                ],
                [
                    'gebruikerID' => 3,
                    'kadeID' => 3,
                    'soort_id' => 2,
                    'ladingDetails' => "ladingDetails3",
                    'aantal' => 3,
                    'isAanwezig' => false,
                    'isBezig' => false,
                    'isAfgewerkt' => false,
                    'startTijd' => DateTime::createFromFormat('Y-m-d H:i','2021-02-02 15:00'),
                    'stopTijd'  =>DateTime::createFromFormat('Y-m-d H:i','2021-02-02 16:00'),

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

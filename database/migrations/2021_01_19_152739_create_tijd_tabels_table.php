<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTijdTabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tijd_tabels', function (Blueprint $table) {
            $table->id();
            $table->string('startTijd');
            $table->string('stopTijd');

            $table->timestamps();
        });
        DB::table('tijd_tabels')->insert(
            [
                [
                    'startTijd' => '8:30',
                    'stopTijd'  =>'9:00'

                ],
                [
                    'startTijd' => '9:00',
                    'stopTijd'  =>'9:30'
                ],
                [
                    'startTijd' => '9:00',
                    'stopTijd'  =>'9:30'
                ],
                [
                    'startTijd' => '9:30',
                    'stopTijd'  =>'10:00'
                ],

                [
                    'startTijd' => '10:30',
                    'stopTijd'  =>'11:00'
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
        Schema::dropIfExists('tijd_tabels');
    }
}

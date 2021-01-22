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
            $table->dateTime('startTijd');
            $table->dateTime('stopTijd');

            $table->timestamps();
        });
        DB::table('tijd_tabels')->insert(
            [
                [
                    'startTijd' => DateTime::createFromFormat('Y-m-d H:i','2021-01-20 8:30'),
                    'stopTijd'  => DateTime::createFromFormat('Y-m-d H:i','2021-01-20 9:00')

                ],
                [
                    'startTijd' => DateTime::createFromFormat('Y-m-d H:i','2021-01-21 9:00'),
                    'stopTijd'  =>DateTime::createFromFormat('Y-m-d H:i','2021-01-21 9:30')
                ],
                [
                    'startTijd' => DateTime::createFromFormat('Y-m-d H:i','2021-01-21 14:30'),
                    'stopTijd'  =>DateTime::createFromFormat('Y-m-d H:i','2021-01-21 15:30')
                ],
                [
                    'startTijd' => DateTime::createFromFormat('Y-m-d H:i','2021-01-22 14:30'),
                    'stopTijd'  =>DateTime::createFromFormat('Y-m-d H:i','2021-01-22 15:00')
                ],

                [
                    'startTijd' => DateTime::createFromFormat('Y-m-d H:i','2021-01-23 10:30'),
                    'stopTijd'  =>DateTime::createFromFormat('Y-m-d H:i','2021-01-23 11:00')
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

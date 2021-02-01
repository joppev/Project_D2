<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoortsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soorts', function (Blueprint $table) {
            $table->id();
            $table->string('soortNaam');
            $table->timestamps();
        });

        DB::table('soorts')->insert(
            [
                [
                    'soortNaam' => "laden",

                ],
                [
                    'soortNaam' => "lossen",

                ],
                [
                    'soortNaam' => "check-up",

                ],
                ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soorts');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensordatasTable extends Migration
{
    /**
     * Run the migrations.
    *
     * @return void
     */
    public function up()
    {
        Schema::create('sensordatas', function (Blueprint $table) {
            $table->string('kadeNaam');
            $table->integer('afstand');
            $table->boolean('kadeVrij');
            $table->timestamp('tijdstip');
        });
        DB::table('sensordatas')->insert(
            [
                [
                'kadeNaam' => 'Kade 1',
                'afstand' => 200,
                'kadeVrij' => false,
                'tijdstip' => DateTime::createFromFormat('Y-m-d H:i','2021-02-01 09:40'),
            ],
                [
                    'kadeNaam' => 'Kade 4',
                    'afstand' => 200,
                    'kadeVrij' => true,
                    'tijdstip' => DateTime::createFromFormat('Y-m-d H:i','2021-02-01 09:40'),
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
        Schema::dropIfExists('sensordatas');
    }
}

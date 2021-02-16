<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGescandeNummerplatensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gescande_nummerplatens', function (Blueprint $table) {
            $table->string('plaatcombinatie');
            $table->timestamp('tijdstip');
        });

        DB::table('gescande_nummerplatens')->insert(
            [
                [
                    'plaatcombinatie' => "1ABC123",
                    'tijdstip' => now(),

                ]]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gescande_nummerplatens');
    }
}

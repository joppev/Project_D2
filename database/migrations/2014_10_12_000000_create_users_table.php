<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('naam');
            $table->string('voornaam');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('wachtwoord');
            $table->boolean('isAdmin');
            $table->boolean('isChauffeur');
            $table->boolean('isReceptionist');
            $table->boolean('isLogistiek');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

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

        DB::table('users')->insert(
            [
                [
                    'naam' => 'Doe',
                    'voornaam' => 'Joe',
                    'email' => 'john.doe@example.com',
                    'wachtwoord' => Hash::make('user1234'),
                    'isAdmin' => false,
                    'isChauffeur' => true,
                    'isReceptionist' => false,
                    'isLogistiek' => false,
                    'created_at' => now(),
                    'email_verified_at' => now()
                ],
                [
                    'naam' => 'admin',
                    'voornaam' => 'admin',
                    'email' => 'admin@example.com',
                    'wachtwoord' => Hash::make('admin1234'),
                    'isAdmin' => true,
                    'isChauffeur' => false,
                    'isReceptionist' => false,
                    'isLogistiek' => false,
                    'created_at' => now(),
                    'email_verified_at' => now()
                ],
                [
                    'naam' => 'chauffeur',
                    'voornaam' => 'chauffeur',
                    'email' => 'chauffeur@example.com',
                    'wachtwoord' => Hash::make('user1234'),
                    'isAdmin' => false,
                    'isChauffeur' => true,
                    'isReceptionist' => false,
                    'isLogistiek' => false,
                    'created_at' => now(),
                    'email_verified_at' => now()
                ],
                [
                    'naam' => 'logistiek',
                    'voornaam' => 'logistiek',
                    'email' => 'logistiek@example.com',
                    'wachtwoord' => Hash::make('admin1234'),
                    'isAdmin' => false,
                    'isChauffeur' => false,
                    'isReceptionist' => false,
                    'isLogistiek' => true,
                    'created_at' => now(),
                    'email_verified_at' => now()
                ],

                [
                    'naam' => 'receptionist',
                    'voornaam' => 'receptionist',
                    'email' => 'receptionist@example.com',
                    'wachtwoord' => Hash::make('user1234'),
                    'isAdmin' => false,
                    'isChauffeur' => false,
                    'isReceptionist' => true,
                    'isLogistiek' => false,
                    'created_at' => now(),
                    'email_verified_at' => now()
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
        Schema::dropIfExists('users');
    }
}

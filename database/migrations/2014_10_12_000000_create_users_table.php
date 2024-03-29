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
        Schema::create('users', function(Blueprint $table) {
            $table->id();
            $table->string('provider_id')->unique()->nullable()->default(null);
            $table->string('fname', 255)->nullable()->default(null);
            $table->string('lname', 255)->nullable()->default(null);
            $table->date('bday')->nullable()->default(null);
            $table->string('phone', 50)->unique()->nullable()->default(null);
            $table->string('username', 255)->unique()->nullable()->default(null);
            $table->string('avatar', 255)->default('default_avatar.png');
            $table->string('email')->unique();
            //$table->timestamp('email_verified_at')->nullable()->default(null);
            $table->string('password')->nullable()->default(null);
            $table->string('fcm_token', '255')->nullable()->default(null);
            $table->unsignedBigInteger('place')->nullable()->default(null);
            $table->boolean('active')->nullable()->default(null);
            //$table->rememberToken();
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCafesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cafes', function(Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->unique()->nullable()->default(null);
            $table->string('phone')->unique()->nullable()->default(null);
            $table->string('latitude', 255);
            $table->string('longitude', 255);
            $table->string('mon_fri', 13)->default('00:00-00:00');
            $table->string('saturday', 13)->default('00:00-00:00');
            $table->string('sunday', 13)->default('00:00-00:00');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('cafes');
    }
}

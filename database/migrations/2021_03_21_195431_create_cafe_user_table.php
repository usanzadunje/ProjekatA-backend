<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCafeUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cafe_user', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('cafe_id');
            $table->timestamps();
            $table->primary(['user_id', 'cafe_id']);
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('cafe_id')->references('id')->on('cafes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cafe_user');
    }
}

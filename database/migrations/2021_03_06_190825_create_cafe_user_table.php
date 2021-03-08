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
        // IF USER NEEDS TO SEE WHAT CAFES HE IS SUB TO
        //Schema::create('cafe_user', function (Blueprint $table) {
        //    $table->foreignId('user_id')->constrained();
        //    $table->foreignId('cafe_id')->constrained();
        //    $table->timestamps();
        //});
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

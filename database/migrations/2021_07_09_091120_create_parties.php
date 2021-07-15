<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parties', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('partyUsers_id')->references('id')->on('Party_User');
            $table->foreignId('games_id')->references('id')->on('games');
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
        Schema::dropIfExists('parties');
    }
}

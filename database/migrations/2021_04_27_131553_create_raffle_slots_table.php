<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaffleSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raffle_slots', function (Blueprint $table) {
            $table->increments('slots_id');
            $table->integer('raffle_id')->unsigned();
            $table->integer('player_id')->unsigned();
            $table->foreign('raffle_id')->references('raffle_id')->on('raffles');
            $table->foreign('player_id')->references('player_id')->on('players');
            $table->integer('price_id');
            $table->integer('slot_number');
            $table->tinyInteger('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raffle_slots');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRafflesSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raffles_schedules', function (Blueprint $table) {
            $table->increments('schedule_id');
            $table->integer('raffle_id')->unsigned();
            $table->foreign('raffle_id')->references('raffle_id')->on('raffles');
            $table->dateTime('start_schedule');
            $table->dateTime('end_schedule');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raffles_schedules');
    }
}

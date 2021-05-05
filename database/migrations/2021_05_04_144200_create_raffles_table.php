<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRafflesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raffles', function (Blueprint $table) {
            $table->increments('raffle_id');
            $table->integer('charity_id')->unsigned()->nullable();
            $table->foreign('charity_id')->references('charity_id')->on('charities');
            $table->integer('prize_id')->unsigned();
            $table->foreign('prize_id')->references('prize_id')->on('prizes');
            $table->string('raffle_name');
            $table->string('raffle_desc')->nullable();
            $table->string('image')->nullable();
            $table->integer('slots');
            $table->integer('slot_price')->nullable()->default(1);
            $table->boolean('is_active')->nullable()->default(1);
            $table->integer('created_at');
            $table->integer('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raffles');
    }
}

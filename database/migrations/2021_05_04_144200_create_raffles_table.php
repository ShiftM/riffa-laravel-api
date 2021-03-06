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
            $table->integer('type_id')->unsigned()->nullable();
            $table->foreign('type_id')->references('type_id')->on('raffle_types');
            $table->integer('charity_id')->unsigned()->nullable();
            $table->foreign('charity_id')->references('charity_id')->on('charities');
            $table->integer('prize_id')->unsigned()->nullable();
            $table->foreign('prize_id')->references('prize_id')->on('prizes');
            $table->integer('prize_2')->unsigned()->nullable();
            $table->integer('prize_3')->unsigned()->nullable();
            $table->float('prize1_probability')->unsigned()->nullable();
            $table->float('prize2_probability')->unsigned()->nullable();
            $table->float('prize3_probability')->unsigned()->nullable();
            $table->string('raffle_name');
            $table->string('raffle_desc')->nullable();
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->integer('slots');
            $table->boolean('status')->nullable()->default(1);
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

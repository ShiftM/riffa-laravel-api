<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->increments('player_id');
            $table->string('first_name');
            $table->char('middle_initial')->length(1)->nullable();
            $table->string('last_name');
            $table->string('phone_number')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('profile')->nullable();
            $table->char('address_type')->length(3)->nullable();
            $table->string('address')->nullable();
            $table->integer('birthdate')->length(10)->nullable();
            $table->integer('created_at')->length(10)->unsigned();
            $table->integer('updated_at')->length(10)->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
}

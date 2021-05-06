<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaffleTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raffle_types', function (Blueprint $table) {
            $table->increments('raffle_type_id');
            $table->string('raffle_type_name')->nullable();
            $table->integer('created_at')->length(10)->unsigned()->nullable();
            $table->integer('updated_at')->lenght(10)->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raffle_types');
    }
}

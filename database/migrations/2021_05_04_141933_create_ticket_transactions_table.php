<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_transactions', function (Blueprint $table) {
            $table->increments('transaction_id');
            $table->integer('ticket_id')->unsigned()->nullable();
            $table->foreign('ticket_id')->references('ticket_id')->on('tickets');
            $table->integer('coin_id')->unsigned()->nullable();
            $table->foreign('coin_id')->references('coin_id')->on('coins');
            $table->string('title');
            $table->string('type');
            $table->integer('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_transactions');
    }
}

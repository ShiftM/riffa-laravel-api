<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinsTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins_transactions', function (Blueprint $table) {
            $table->increments('transaction_id');
            $table->integer('coins_id')->unsigned();
            $table->foreign('coins_id')->references('coins_id')->on('coins');
            $table->string('transaction_type');
            $table->date('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coins_transactions');
    }
}

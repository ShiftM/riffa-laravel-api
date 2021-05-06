<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrizeCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prize_categories', function (Blueprint $table) {
            $table->increments('prize_category_id');
            $table->integer('prize_id')->unsigned();
            $table->foreign('prize_id')->references('prize_id')->on('prizes');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('category_id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prize_categories');
    }
}

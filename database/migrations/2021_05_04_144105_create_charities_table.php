<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charities', function (Blueprint $table) {
            $table->increments('charity_id');
            $table->integer('charity_type_id');
            $table->string('charity_name');
            $table->string('description')->nullable();
            $table->string('contact_person');
            $table->string('contact_number')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->nullable()->default(1);
            $table->integer('created_at')->length(10);
            $table->integer('updated_at')->length(10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charities');
    }
}

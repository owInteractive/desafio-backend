<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moviments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('financial_id')->unsigned();
            $table->bigInteger('moviment_type_id')->unsigned();
            $table->double('value', 12, 2);

            $table->timestamps();
            $table->foreign('financial_id')->references('id')->on('financials');
            $table->foreign('moviment_type_id')->references('id')->on('moviment_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moviments');
    }
}

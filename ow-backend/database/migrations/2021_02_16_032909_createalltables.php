<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createalltables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('balance')->default('1000');
            $table->string('credit')->default('500');
            $table->date('birthdate');
            $table->datetime('created_at');
            $table->datetime('updated_at');
        });

        Schema::create('moves', function(Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('value');
            $table->integer('id_user');
            $table->datetime('created_at');
            $table->datetime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropDatabaseIfExists('users');
        Schema::dropDatabaseIfExists('moves');
    }
}

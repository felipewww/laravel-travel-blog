<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Interest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interests', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('color');
        });

        Schema::create('cities_has_interests', function (Blueprint $table){
            $table->integer('city_id')->unsigned();
            $table->integer('interest_id')->unsigned();

            $table->primary(['city_id', 'interest_id']);

            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('interest_id')->references('id')->on('interests')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('places_has_interests', function (Blueprint $table) {
            $table->integer('place_id')->unsigned();
            $table->integer('interest_id')->unsigned();

            $table->primary(['place_id', 'interest_id']);

            $table->foreign('place_id')->references('id')->on('places')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('interest_id')->references('id')->on('interests')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('interests');
        Schema::dropIfExists('cities_has_interests');
        Schema::dropIfExists('places_has_interests');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

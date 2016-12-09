<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WorldEstructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('est_continent', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('name', 45)->unique();
        });

        Schema::create('est_country', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->integer('continent_id')->unsigned();

            $table->unique('name');
            $table->foreign('continent_id')->references('id')->on('est_continent')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::create('est_estate', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->integer('country_id')->unsigned();

            $table->unique('name');
            $table->foreign('country_id')->references('id')->on('est_country')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::create('est_city', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->text('content');
            $table->text('content_strip');
            $table->integer('estate_id')->unsigned();

            $table->unique('name');
            $table->foreign('estate_id')->references('id')->on('est_estate')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::create('est_city_photos', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('path')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('est_city');
        Schema::dropIfExists('est_estate');
        Schema::dropIfExists('est_country');
        Schema::dropIfExists('est_continent');
    }
}

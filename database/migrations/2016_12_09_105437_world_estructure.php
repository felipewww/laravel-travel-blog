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
        Schema::create('continents', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('name', 45)->unique();
        });

        Schema::create('countries', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->integer('continent_id')->unsigned();
            $table->text('content')->nullable();
            $table->text('content_strip')->nullable();
            $table->string('sigla_2', 2);
            $table->string('sigla_3', 3);

            $table->unique('name');
            $table->foreign('continent_id')->references('id')->on('continents')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::create('estates', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('uf',45);
            $table->integer('country_id')->unsigned();

            $table->unique('name');
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::create('cities', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->text('content')->nullable();
            $table->text('content_strip')->nullable();
            $table->boolean('status')->default(false);
            $table->integer('estate_id')->unsigned();
            $table->integer('views')->default(0);

            $table->unique('name');
            $table->foreign('estate_id')->references('id')->on('estates')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::create('city_photos', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('path');
            $table->integer('city_id')->unsigned();

            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('cities', function (Blueprint $table){
            $table->integer('est_city_photos_id')->unsigned()->nullable();
            $table->foreign('est_city_photos_id')->references('id')->on('city_photos')->onUpdate('restrict')->onDelete('restrict');
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
        Schema::dropIfExists('cities');
        Schema::dropIfExists('estates');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('continents');
        Schema::dropIfExists('city_photos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

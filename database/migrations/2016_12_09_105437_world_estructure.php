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
            $table->string('sigla_2', 2);
            $table->string('sigla_3', 3);
            $table->unique('name');
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('long', 10, 7)->nullable();

            $table->integer('continents_id')->unsigned();
            $table->foreign('continents_id')->references('id')->on('continents')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::create('estates', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('name')->unique();
            $table->string('uf',45);
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('long', 10, 7)->nullable();

            $table->integer('countries_id')->unsigned();
            $table->foreign('countries_id')->references('id')->on('countries')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::create('cities', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('name')->unique();
            $table->boolean('status')->default(false);
            $table->integer('estates_id')->unsigned();
            $table->integer('views')->default(0);
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('long', 10, 7)->nullable();

            $table->foreign('estates_id')->references('id')->on('estates')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::create('cities_photos', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('path');

            $table->integer('cities_id')->unsigned();
            $table->foreign('cities_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('cities_has_interests', function (Blueprint $table){
            $table->integer('cities_id')->unsigned();
            $table->integer('interests_id')->unsigned();

            $table->primary(['cities_id', 'interests_id']);

            $table->foreign('cities_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('interests_id')->references('id')->on('interests')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('cities', function (Blueprint $table){
            $table->integer('cities_photos_id')->unsigned()->nullable();
            $table->foreign('cities_photos_id')->references('id')->on('cities_photos')->onUpdate('restrict')->onDelete('restrict');
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
        Schema::dropIfExists('cities_photos');
        Schema::dropIfExists('cities_has_interests');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

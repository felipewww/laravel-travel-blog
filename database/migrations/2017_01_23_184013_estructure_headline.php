<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EstructureHeadline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('headlines', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->text('content');
            $table->text('src');

            $table->timestamps();

            $table->text('polymorphic_from');
//            $table->morphs('headline_morph');
        });

        Schema::create('cities_has_headlines', function (Blueprint $table) {
            $table->increments('headline_id')->unsigned();
            $table->integer('city_id')->unsigned();

            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('headline_id')->references('id')->on('headlines')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('countries_has_headlines', function (Blueprint $table) {
            $table->increments('headline_id')->unsigned();
            $table->integer('country_id')->unsigned();

            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('headline_id')->references('id')->on('headlines')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('posts_has_headlines', function (Blueprint $table) {
            $table->increments('headline_id')->unsigned();
            $table->integer('post_id')->unsigned();

            $table->foreign('post_id')->references('id')->on('posts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('headline_id')->references('id')->on('headlines')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('places_has_headlines', function (Blueprint $table) {
            $table->increments('headline_id')->unsigned();
            $table->integer('place_id')->unsigned();

            $table->foreign('place_id')->references('id')->on('places')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('headline_id')->references('id')->on('headlines')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('headlines');
        Schema::dropIfExists('cities_has_headlines');
        Schema::dropIfExists('countries_has_headlines');
        Schema::dropIfExists('posts_has_headlines');
        Schema::dropIfExists('places_has_headlines');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

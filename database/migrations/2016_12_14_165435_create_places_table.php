<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('icon');

            $table->integer('places_categories_id')->unsigned()->nullable();
            $table->foreign('places_categories_id')->references('id')->on('places_categories')->onUpdate('cascade')->onDelete('restrict');
        });

        Schema::create('places', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->timestamps();
            $table->string('title');
            $table->text('content');

            $table->integer('cities_id')->unsigned();
            $table->foreign('cities_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');

//            $table->integer('places_subcategories_id')->unsigned();
//            $table->foreign('places_subcategories_id')->references('id')->on('places_subcategories')->onUpdate('cascade')->onDelete('restrict');
        });

        Schema::create('places_photos', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('path');

            $table->integer('places_id')->unsigned();
            $table->foreign('places_id')->references('id')->on('places')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('places_has_interests', function (Blueprint $table) {
            $table->integer('places_id')->unsigned();
            $table->integer('interests_id')->unsigned();

            $table->primary(['places_id', 'interests_id']);

            $table->foreign('places_id')->references('id')->on('places')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('interests_id')->references('id')->on('interests')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('places_categories');
        Schema::dropIfExists('places_subcategories');
        Schema::dropIfExists('places');
        Schema::dropIfExists('places_photos');
        Schema::dropIfExists('places_has_interests');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

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
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->timestamps();
            $table->string('title');
            $table->text('content');

            $table->boolean('status')->default(0);

            $table->text('search_tags')->nullable();
            $table->text('seo_tags')->nullable();
            $table->text('main_photo');

            $table->integer('cities_id')->unsigned();
            $table->foreign('cities_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('editorials_id')->unsigned();
            $table->foreign('editorials_id')->references('id')->on('editorials')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('places_photos', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('path');

            $table->integer('places_id')->unsigned();
            $table->foreign('places_id')->references('id')->on('places')->onUpdate('cascade')->onDelete('cascade');
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
//        Schema::dropIfExists('places_categories');
        Schema::dropIfExists('places');
        Schema::dropIfExists('places_photos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

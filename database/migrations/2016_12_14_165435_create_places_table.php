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

            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();

            $table->integer('cities_id')->unsigned();
            $table->foreign('cities_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('editorials_id')->unsigned();
            $table->foreign('editorials_id')->references('id')->on('editorials')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('place_photos', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->increments('position');
            $table->string('path');
            $table->string('description');

            $table->integer('place_id')->unsigned();
            $table->foreign('place_id')->references('id')->on('places')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('places');
        Schema::dropIfExists('place_photos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->text('content_regions');

            $table->string('polymorphic_from');

            $table->text('search_tags');
            $table->text('seo_tags');

            $table->dateTime('starts');
            $table->dateTime('ends');

            $table->integer('editorial_id')->unsigned();
            $table->foreign('editorial_id')->references('id')->on('editorials')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('city_has_events', function (Blueprint $table){
            $table->increments('event_id')->unsigned();
            $table->integer('city_id')->unsigned();

            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('places_has_events', function (Blueprint $table) {
            $table->increments('event_id')->unsigned();
            $table->integer('place_id')->unsigned();

            $table->foreign('place_id')->references('id')->on('places')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('events_has_interests', function (Blueprint $table) {
            $table->integer('event_id')->unsigned();
            $table->integer('interest_id')->unsigned();

            $table->primary(['event_id', 'interest_id']);

            $table->foreign('event_id')->references('id')->on('events')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('interest_id')->references('id')->on('interests')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('events_has_headlines', function (Blueprint $table) {
            $table->increments('headline_id')->unsigned();
            $table->integer('country_id')->unsigned();

            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('events');
        Schema::dropIfExists('city_has_events');
        Schema::dropIfExists('places_has_events');
        Schema::dropIfExists('events_has_interests');
        Schema::dropIfExists('events_has_headlines');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

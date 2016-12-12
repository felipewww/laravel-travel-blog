<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Posts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_types', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        Schema::create('posts', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->text('content');
            $table->text('content_strip');

            $table->timestamps();

            $table->morphs('polimorph_from');

            $table->integer('post_type_id')->unsigned();
            $table->foreign('post_type_id')->references('id')->on('post_types')->onUpdate('cascade')->onDelete('restrict');
        });

        Schema::create('post_photos', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('path');
            $table->string('description');

            $table->integer('post_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('posts')->onUpdate('cascade')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_photos');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('post_types');
    }
}

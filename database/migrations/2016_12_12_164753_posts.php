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

        Schema::create('authors', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->text('description');
            $table->text('photo');

            $table->integer('users_id')->unsigned();
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
        });

        Schema::create('posts', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->text('content');
            $table->text('content_strip');
            $table->string('seo_tags')->nullable();

            $table->timestamps();

            $table->morphs('polimorph_from');

            $table->integer('authors_id')->unsigned();
            $table->foreign('authors_id')->references('id')->on('authors')->onUpdate('cascade')->onDelete('restrict');

            $table->integer('post_types_id')->unsigned();
            $table->foreign('post_types_id')->references('id')->on('post_types')->onUpdate('cascade')->onDelete('restrict');
        });

        Schema::create('posts_headlines', function (Blueprint $table){
            $table->text('title');
            $table->text('content');
            $table->enum('media_type',['photo','video','gallery']);
            $table->string('path');

            $table->integer('posts_id')->unsigned();
            $table->foreign('posts_id')->references('id')->on('posts')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('post_photos', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('path');
            $table->string('description');

            $table->integer('posts_id')->unsigned();
            $table->foreign('posts_id')->references('id')->on('posts')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('post_photos');
        Schema::dropIfExists('post_headlines');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('posts_headlines');
        Schema::dropIfExists('authors');
        Schema::dropIfExists('post_types');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

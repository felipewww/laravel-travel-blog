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
            $table->string('initials', 2)->unique();
        });

        Schema::create('countries', function (Blueprint $table){
            //$table->increments('id')->unsigned();
            $table->integer('id')->primary()->unsigned()->unique();
            $table->string('name');
            $table->string('iso_2', 2);
            $table->string('iso_3', 3);
            $table->string('iso_numeric', 10);
            $table->string('currency_code', 3);
            $table->string('language');
            $table->string('capital');

            $table->decimal('ll_north', 10, 7)->nullable();
            $table->decimal('ll_south', 10, 7)->nullable();
            $table->decimal('ll_east', 10, 7)->nullable();
            $table->decimal('ll_west', 10, 7)->nullable();

            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();

            $table->integer('continents_id')->unsigned();
            $table->foreign('continents_id')->references('id')->on('continents')->onUpdate('restrict')->onDelete('restrict');

            /*
             * Existem paises que tem observações específicas, ex: Reino unido foi cadastrado
             * posteriormente no banco sendo dividido entre os 4 paises que o mantém com este nome
             *
             * Essas observações vem aqui em formato JSON para futura pesquisa ou até exibição na tela
             * */
            $table->text('system_notes')->nullable();

            /*cofig página do país*/
//            $def = json_encode(['nenhum conteúdo'], JSON_UNESCAPED_UNICODE);
            $table->text('content_regions')->nullable();
            $table->boolean('status')->default(0);

            $table->text('comments')->nullable();
            $table->text('search_tags')->nullable();
            $table->text('seo_tags')->nullable();

            $table->timestamps();
        });

        Schema::create('cities', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('name');

//            $table->integer('estates_id')->unsigned();
            $table->integer('country_id')->unsigned();

            $table->decimal('ll_north', 10, 7);
            $table->decimal('ll_south', 10, 7);
            $table->decimal('ll_east', 10, 7);
            $table->decimal('ll_west', 10, 7);

            $table->decimal('lat', 10, 7);
            $table->decimal('lng', 10, 7);

//            $table->foreign('estates_id')->references('id')->on('estates')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('restrict')->onDelete('restrict');

            $table->text('content_regions')->nullable();
            $table->boolean('status')->default(0);

            $table->text('comments')->nullable();
            $table->text('search_tags')->nullable();
            $table->text('seo_tags')->nullable();
            $table->text('geoadmins')->nullable(); //admin1 and admin2 - hierarchy

            $table->timestamps();
        });

        Schema::create('city_photos', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('path');
            $table->string('description', 255);
            $table->integer('position');

            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('cities', function (Blueprint $table){
            $table->integer('cities_photos_id')->unsigned()->nullable();
            $table->foreign('cities_photos_id')->references('id')->on('city_photos')->onUpdate('restrict')->onDelete('restrict');
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
        Schema::dropIfExists('countries');
        Schema::dropIfExists('continents');
        Schema::dropIfExists('city_photos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

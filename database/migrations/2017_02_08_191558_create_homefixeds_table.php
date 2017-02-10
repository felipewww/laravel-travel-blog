<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomefixedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homefixeds', function (Blueprint $table) {
//            $table->increments('id');
            $table->integer('region');
            $table->integer('position');

            $table->integer('home_id')->unsigned();
            $table->foreign('home_id')->references('id')->on('homes')->onUpdate('cascade')->onDelete('restrict');

            $table->integer('headline_id')->unsigned();
            $table->foreign('headline_id')->references('id')->on('headlines')->onUpdate('cascade')->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('homefixeds');
    }
}

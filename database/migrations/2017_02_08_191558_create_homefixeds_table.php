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
            $table->integer('position');

            $table->integer('home_id')->unsigned();
            $table->foreign('home_id')->references('id')->on('homes')->onUpdate('cascade')->onDelete('restrict');

            $table->integer('headline_id')->unsigned();
            $table->foreign('headline_id')->references('id')->on('headlines')->onUpdate('cascade')->onDelete('restrict');

            $table->timestamps();

            $table->primary(array('home_id', 'headline_id'));
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

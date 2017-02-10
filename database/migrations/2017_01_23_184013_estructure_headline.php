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

            $table->morphs('headline_morph');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

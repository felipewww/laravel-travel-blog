<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description')->nullable();
            $table->integer('layout')->default(1); //numero da view setado manualmente no codigo, isso jamais sera criado via painel!
            $table->integer('views')->default(0); //qtde de views
            $table->integer('clicks')->default(0); //qtde de clicks nas noticias. Talvez um json até para saber em qualREGION clicou
            $table->dateTime('start')->nullable(); //data em que realmente começou a exibir. Ajustar isos no codigo, qdo definir status 1, valendo!
            $table->dateTime('end')->nullable(); //inverso do start.
            $table->boolean('available')->default(0); //se a home ja esta completamente configurado, o status poderá ser alterado para TRUE. caso falte alguma region ou config, não poderá ser STATUS 1
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('homes');
    }
}

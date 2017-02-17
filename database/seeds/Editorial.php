<?php

use Illuminate\Database\Seeder;

class Editorial extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('editorials')->insert
        (
            array(
                [
                    'name' => 'Arte e Cultura',
                    'icon' => 'red'
                ],
                [
                    'name' => 'Comer e Beber',
                    'icon' => 'red'
                ],
                [
                    'name' => 'Estilo de Vida',
                    'icon' => 'red'
                ],
                [
                    'name' => 'Pra Você', //info
                    'icon' => 'red'
                ],
            )
        );
    }
}

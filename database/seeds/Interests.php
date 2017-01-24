<?php

use Illuminate\Database\Seeder;

class Interests extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('interests')->insert
        (
            array(
                [
                    'name' => 'Cruzeiro',
                    'color' => 'red'
                ],
                [
                    'name' => 'Família',
                    'color' => 'red'
                ],
                [
                    'name' => 'Romance',
                    'color' => 'red'
                ],
                [
                    'name' => 'Cultura',
                    'color' => 'red'
                ],
                [
                    'name' => 'Praia',
                    'color' => 'red'
                ],
                [
                    'name' => 'Gastronomia',
                    'color' => 'red'
                ],
                [
                    'name' => 'Spa',
                    'color' => 'red'
                ],
                [
                    'name' => 'Fitness',
                    'color' => 'red'
                ],
                [
                    'name' => 'Aventura',
                    'color' => 'red'
                ],
                [
                    'name' => 'Para Trabalho',
                    'color' => 'red'
                ],
                [
                    'name' => 'Calor',
                    'color' => 'red'
                ],
                [
                    'name' => 'Frio',
                    'color' => 'red'
                ],
                [
                    'name' => 'Mochilão',
                    'color' => 'red'
                ],
                [
                    'name' => 'Sozinho',
                    'color' => 'red'
                ],
                [
                    'name' => 'Amigos',
                    'color' => 'red'
                ],
            )
        );
    }
}

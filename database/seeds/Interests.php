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
        DB::table('post_types')->insert
        (
            array(
                ['name' => 'Cruzeiro'],
                ['name' => 'Família'],
                ['name' => 'Romance'],
                ['name' => 'Cultura'],
                ['name' => 'Praia'],
                ['name' => 'Gastronomia'],
                ['name' => 'Spa'],
                ['name' => 'Fitness'],
                ['name' => 'Aventura'],
                ['name' => 'Para Trabalho'],
                ['name' => 'Calor'],
                ['name' => 'Frio'],
                ['name' => 'Mochilão'],
                ['name' => 'Sozinho'],
                ['name' => 'Amigos'],
            )
        );
    }
}

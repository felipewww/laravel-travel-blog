<?php

use Illuminate\Database\Seeder;

class WorldEstructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $continents = array(
            ['name' => 'América do Norte'],
            ['name' => 'América Central'],
            ['name' => 'América do Sul'],
            ['name' => 'África'],
            ['name' => 'Europa'],
            ['name' => 'Ásia'],
            ['name' => 'Oceania'],
            ['name' => 'Antártida']
        );

        DB::table('continents')->insert($continents);

        $countries = array(
            ['name' => 'Brasil', 'continent_id' => '3', 'sigla_2' => 'BR', 'sigla_3' => 'BRA']
        );

        DB::table('countries')->insert($countries);

        $estates = array(
            ['name' => 'São Paulo', 'uf' => 'SP', 'country_id' => 1]
        );

        DB::table('estates')->insert($estates);

        $cities = array(
            ['name' => 'São Paulo', 'estate_id' => 1]
        );

        DB::table('cities')->insert($cities);
    }
}

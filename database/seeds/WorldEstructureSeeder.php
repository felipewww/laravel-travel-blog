<?php

use Illuminate\Database\Seeder;

class WorldEstructureSeeder extends Seeder
{
    public $continents = array(
        ['id' => 0, 'name' => 'América do Norte'],
        ['id' => 1, 'name' => 'América Central'],
        ['id' => 2, 'name' => 'América do Sul'],
        ['id' => 3, 'name' => 'África'],
        ['id' => 4, 'name' => 'Europa'],
        ['id' => 5, 'name' => 'Ásia'],
        ['id' => 6, 'name' => 'Oceania'],
        ['id' => 7, 'name' => 'Antártida']
    );
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('continents')->insert($this->continents);

        $countries = array(
            ['name' => 'Brasil', 'continents_id' => '3', 'sigla_2' => 'BR', 'sigla_3' => 'BRA'],
            ['name' => 'Colômbia', 'continents_id' => '3', 'sigla_2' => 'BR', 'sigla_3' => 'BRA'],

            ['name' => 'Cuba', 'continents_id' => '2', 'sigla_2' => 'CU', 'sigla_3' => 'CUB'],

            ['name' => 'Estados Unidos', 'continents_id' => '1', 'sigla_2' => 'US', 'sigla_3' => 'USA'],
            ['name' => 'México', 'continents_id' => '1', 'sigla_2' => 'MX', 'sigla_3' => 'MEX'],

            ['name' => 'África do Sul', 'continents_id' => '4', 'sigla_2' => 'ZA', 'sigla_3' => 'ZAF'],
        );

        DB::table('countries')->insert($countries);

        $estates = array(
            ['name' => 'São Paulo', 'uf' => 'SP', 'countries_id' => 1],
            ['name' => 'Bahia', 'uf' => 'SP', 'countries_id' => 1],
            ['name' => 'Santa Catarina', 'uf' => 'SP', 'countries_id' => 1]
        );

        DB::table('estates')->insert($estates);

        $cities = array(
            ['name' => 'São Paulo', 'estates_id' => 1],
            ['name' => 'Salvador', 'estates_id' => 2],
            ['name' => 'Florianópolis', 'estates_id' => 3],
        );

        DB::table('cities')->insert($cities);
    }

    public function countries()
    {
        $array = json_decode( file_get_contents(base_path().'/database/seeds/countries.txt') , true );

        $i = 0;
        while ($i < 5)
        {
            echo '<pre>';
            print_r($array[$i]);
            echo '</pre>';
        }
    }
}

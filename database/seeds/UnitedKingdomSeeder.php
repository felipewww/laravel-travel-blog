<?php

use Illuminate\Database\Seeder;

class UnitedKingdomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Geograficamente o correto seria apenas United Kingdom (Reino Unido), porém, o ideal é cadastrar cada "país"
     * do reino unido separadamente a fim de pesquisas mais completas conforme o conhecimento das pessoas.
     *
     * Então, o arquivo unitedKingdom.txt foi gerado com base nas informações do Geonames e com algumas alterações
     * manuais como:
     * - iso [2,3, numeric] do Reino Unido
     * - Nomes do Inglês para português pois faltava tradução
     * - currencyCode (moeda)
     * - Languages
     * - Capital (Londres)
     *
     * @return void
     */
    public function run()
    {
        $array = json_decode( file_get_contents(base_path().'/public/Geonames/unitedKingdomSeeder.txt') , true )['geonames'];

        $comments = [
            [
                'message' => 'Este país geograficamente faz parte do Reino Unido. Foi separado manualmente para atender 
                a necessidade cultural para pesquisas e informações no site. DEV: Mais informações em UnitedKingdomSeeder.php',
                'country_id' => '2635167'
            ]
        ];

        foreach ($array as &$country_of_uk)
        {
            $country_of_uk['comments'] = json_encode($comments);
        }

        $fullData = WorldEstructureSeeder::makeData($array);
        DB::table('countries')->insert($fullData);
    }
}

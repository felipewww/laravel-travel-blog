<?php

use Illuminate\Database\Seeder;

class WorldEstructureSeeder extends Seeder
{
    public $continents = array(
        ['id' => 1, 'initials' => 'NA', 'name' => 'América do Norte'],
        ['id' => 2, 'initials' => 'CA', 'name' => 'América Central'],
        ['id' => 3, 'initials' => 'SA', 'name' => 'América do Sul'],
        ['id' => 4, 'initials' => 'AF', 'name' => 'África'],
        ['id' => 5, 'initials' => 'EU', 'name' => 'Europa'],
        ['id' => 6, 'initials' => 'AS', 'name' => 'Ásia'],
        ['id' => 7, 'initials' => 'OC', 'name' => 'Oceania'],
        ['id' => 8, 'initials' => 'AN', 'name' => 'Antártida']
    );
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('continents')->insert($this->continents);

        $fields = [
            'iso_numeric', 'iso3', 'iso2', 'geoname_id', 'currency_code', 'language', 'continents_id',
            'north', 'south', 'east', 'west'
        ];

//        $countries = array(
//            ['name' => 'Brasil', 'continents_id' => '3', 'sigla_2' => 'BR', 'sigla_3' => 'BRA'],
//            ['name' => 'Colômbia', 'continents_id' => '3', 'sigla_2' => 'BR', 'sigla_3' => 'BRA'],
//
//            ['name' => 'Cuba', 'continents_id' => '2', 'sigla_2' => 'CU', 'sigla_3' => 'CUB'],
//
//            ['name' => 'Estados Unidos', 'continents_id' => '1', 'sigla_2' => 'US', 'sigla_3' => 'USA'],
//            ['name' => 'México', 'continents_id' => '1', 'sigla_2' => 'MX', 'sigla_3' => 'MEX'],
//
//            ['name' => 'África do Sul', 'continents_id' => '4', 'sigla_2' => 'ZA', 'sigla_3' => 'ZAF'],
//        );

        DB::table('countries')->insert($this->countries());

        $estates = array(
            ['name' => 'São Paulo', 'uf' => 'SP', 'countries_id' => 1],
            ['name' => 'Bahia', 'uf' => 'SP', 'countries_id' => 1],
            ['name' => 'Santa Catarina', 'uf' => 'SP', 'countries_id' => 1]
        );
//
//        DB::table('estates')->insert($estates);
//
//        $cities = array(
//            ['name' => 'São Paulo', 'estates_id' => 1],
//            ['name' => 'Salvador', 'estates_id' => 2],
//            ['name' => 'Florianópolis', 'estates_id' => 3],
//        );
//
//        DB::table('cities')->insert($cities);
    }

    public function countries()
    {
        $array = json_decode( file_get_contents(base_path().'/database/seeds/countries.txt') , true )['geonames'];
        $fullData = array();

        foreach ($array as $countryKey => $country)
        {
            if (true)
            {
                $cont_initials = $country['continent'];
                foreach ($this->continents as $key => $continent)
                {
                    if ($continent['initials'] === $cont_initials)
                    {
                        $data = [
                            'id'            => $country['geonameId'],
                            'name'          => $country['countryName'],
                            'iso_2'         => $country['countryCode'],
                            'iso_3'         => $country['isoAlpha3'],
                            'iso_numeric'   => $country['isoNumeric'],
                            'currency_code' => $country['currencyCode'],
                            'language'      => $country['languages'],
                            'capital'       => $country['capital'],
                            'll_north'      => $country['north'],
                            'll_south'      => $country['south'],
                            'll_east'       => $country['east'],
                            'll_west'       => $country['west'],
                            'lat'           => ($country['north']+$country['south'])/2,
                            'lng'           => ($country['east']+$country['west'])/2,
                            'continents_id' => $this->continents[$key]['id'],
                        ];

                        array_push($fullData, $data);
                    }
                }
            }
        }

        return $fullData;
    }
}

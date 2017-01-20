<?php

use Illuminate\Database\Seeder;

class WorldEstructureSeeder extends Seeder
{
    public static $continents = array(
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
        DB::table('continents')->insert(self::$continents);
        DB::table('countries')->insert($this->countries());
        DB::table('estates')->insert($this->estates());
        DB::table('cities')->insert($this->cities());
    }

    public function countries()
    {
        $array = json_decode( file_get_contents(base_path().'/public/Geonames/countries.txt') , true )['geonames'];
        $fake = [
            'geonameId'     => 1120112600,
            'continent'     => 'SA',
            'countryName'   => 'País Pra Viajar [teste]',
            'countryCode'   => 'TS',
            'isoAlpha3'     => 'TST',
            'isoNumeric'    => '1234567890',
            'currencyCode'  => 'BRL',
            'languages'     => 'PT-BR',
            'capital'       => 'Pensilvânia',
            'north'         => Faker\Provider\en_US\Address::latitude(),
            'south'         => Faker\Provider\en_US\Address::longitude(),
            'east'          => Faker\Provider\en_US\Address::latitude(),
            'west'          => Faker\Provider\en_US\Address::latitude(),
            'comments'      => json_encode([['message' => 'Apenas um Faker de teste']])
        ];

        array_push($array, $fake);

        return self::makeData($array);
    }

    public function estates()
    {
        $fake = [
            'id'            => 1120112600,
            'name'          => 'Estado [teste]',

            'uf'            => 'SP',
            'll_north'      => Faker\Provider\en_US\Address::latitude(),
            'll_south'      => Faker\Provider\en_US\Address::longitude(),
            'll_east'       => Faker\Provider\en_US\Address::latitude(),
            'll_west'       => Faker\Provider\en_US\Address::longitude(),
            'lat'           => Faker\Provider\en_US\Address::latitude(),
            'lng'           => Faker\Provider\en_US\Address::longitude(),
            'countries_id'  => 1120112600,
            'comments'      => json_encode([['message' => 'Apenas um Faker de teste']])
        ];

        return [$fake];
    }

    public function cities()
    {
        $fake = [
            'id'            => 1120112600,
            'name'          => 'Cidade [teste]',
            'estates_id'    => 1120112600,

            'll_north'      => Faker\Provider\en_US\Address::latitude(),
            'll_south'      => Faker\Provider\en_US\Address::longitude(),
            'll_east'       => Faker\Provider\en_US\Address::latitude(),
            'll_west'       => Faker\Provider\en_US\Address::longitude(),
            'lat'           => Faker\Provider\en_US\Address::latitude(),
            'lng'           => Faker\Provider\en_US\Address::longitude(),
            'comments'      => json_encode([['message' => 'Apenas um Faker de teste']])
        ];

        return [$fake];
    }

    public function fake()
    {

    }

    public static function makeData($array)
    {
        $fullData = [];
        foreach ($array as $countryKey => $country)
        {
            $cont_initials = $country['continent'];
            foreach (self::$continents as $key => $continent)
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
                        'continents_id' => self::$continents[$key]['id'],
                        'comments'      => $country['comments'] ?? null
                    ];

                    array_push($fullData, $data);
                }
            }
        }

        return $fullData;
    }
}

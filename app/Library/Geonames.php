<?php

namespace Lib;

use App\Library\Jobs;
use Illuminate\Http\Request;
use Painel\World\Estate;

class Geonames {
    private $username = 'praviajar';

    use Jobs;

    public function findACity($name, $countryIso)
    {
        $name = str_replace(' ', '%20', $name);
        $service_url = "http://api.geonames.org/searchJSON?name=$name&country=$countryIso&username=$this->username&maxRows=1000&style=full&lang=pt&orderBy=population&inclBbox=true&featureClass=P";

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $curl_response = curl_exec($curl);
        curl_close($curl);


        return json_decode($curl_response, true);
    }
}
<?php

namespace App\Http\Controllers\Dev;
use Illuminate\Http\Request;

class IndexController extends \App\Http\Controllers\Controller {

    public function index($action)
    {
        $this->$action();
    }

    /** @deprecated
     *  função enviada para class Geonames. Chamar essa função daqui e enviar parametros para cá via GET
     * */
    function getEstates()
    {
        $geonameID  = 3469034;
        $name       = 'Coração [teste]';
        $path       = base_path().'/public/Geonames/Estates/';
        $fileName   = $name.'_gnid'.$geonameID.'.txt';

        $createNew = function() use ($path, $geonameID, $fileName)
        {
            echo 'Não Existia';
            //GEONAME REST
            $service_url = 'http://api.geonames.org/childrenJSON?formatted=true&geonameId='.$geonameID.'&username=praviajar&style=full';
            $curl = curl_init($service_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $curl_response = curl_exec($curl);
            curl_close($curl);

            //Criar arquivo JSON

            //converter para json e inserir data de criação
            $curl_response = json_decode($curl_response, true);
            $curl_response['created_at'] = time();

            $content = json_encode($curl_response); //converter novamente para string json
            $fp = fopen($path.$fileName, "wb");
            fwrite($fp,$content);
            fclose($fp);

            return $curl_response;
        };

        $readExists = function () use($path, $fileName)
        {
            echo 'Existe';
            $content = file_get_contents($path.$fileName);
            return json_decode($content, true);
        };

        $json = ( file_exists($path.$fileName) ) ? $readExists() : $createNew();
        dd($json);
    }
}
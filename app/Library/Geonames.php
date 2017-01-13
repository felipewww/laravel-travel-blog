<?php

namespace Lib;

use Painel\World\Estate;

class Geonames {
    private $username = 'praviajar';

    public function children($type, $placeName, $id)
    {
        $path       = base_path().'/public/Geonames/';
        $fileName   = $placeName.'_gnid'.$id.'.txt';

        switch ($type)
        {
            case 'estates':
                $path .= 'Estates/';
                break;

            case 'cities':
                $path .= 'Cities/';
                break;

            default:
                trigger_error('$type deve ser "cities" ou "estates"', E_USER_ERROR);
                break;
        }

        if( file_exists($path.$fileName) )
        {
            $json = file_get_contents($path.$fileName);
        }
        else
        {
            $json = $this->getChildren($id);
            $this->createFile($json, $path.$fileName);
        }
        return json_decode($json, true);

    }

    protected function getChildren($id)
    {
        //Geonames Children REST
        $service_url = "http://api.geonames.org/childrenJSON?geonameId=$id&username=$this->username&style=full&lang=en";
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        curl_close($curl);

        return $curl_response;
    }

    protected function createFile($json_string, $path)
    {
        //converter para json e inserir data de criação
        $curl_response = json_decode($json_string, true);
        $curl_response['created_at'] = time();

        $content = json_encode($curl_response); //converter novamente para string json

        $fp = fopen($path, "wb");
        fwrite($fp,$content);
        fclose($fp);
    }
}
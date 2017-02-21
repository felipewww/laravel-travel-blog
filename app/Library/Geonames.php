<?php

namespace Lib;

use App\Library\Jobs;
use Illuminate\Http\Request;
use Painel\World\Estate;

class Geonames {
    private $username = 'praviajar';

    use Jobs;

    public function children($type, $placeName, $id, $paramns = [])
    {
//        dd($paramns);
        $isTest         = (isset($paramns['isTest'])) ? $paramns['isTest'] : true;
        $generateFile   = (isset($paramns['generateFile'])) ? (bool)$paramns['generateFile'] : true;
        $addComment     = (isset($paramns['addComment'])) ? $paramns['addComment'] : false;
        $updateFile     = (isset($paramns['updateFile'])) ? (bool)$paramns['updateFile'] : false;

        $path       = base_path().'/public/Geonames/';
        $fileName   = strtolower($this->_toAscii($placeName)).'_gnid'.$id.'.txt';

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

        /*Inserir mais registros no arquivo*/
        if( $updateFile )
        {
            $json = $this->getChildren($paramns['getChildrenFromThisId'], $paramns);

            //Obrigatorio enviar esse parametro para fazer a atualização de arquivo. Então, por padrão, qualquer consulta de
            //de cidades a mais de uma localidade, sempre será apenas uma consulta pra ver se esta retornando certo.
            if ($isTest != 'false') {
                echo 'Para salvar o resultado no arquivo, altere countryInfo.isTest para FALSE e rode o script novamente.<br>';
                echo 'Resultado encontrado: ';
                dd( json_decode($json, true) );
            }

            //Adicionar comentários [coluna comment no banco] caso esta cidade tenha sido gerada de forma indireta ou manual
            if( $addComment ){
                $json = $this->addComment($json, $paramns['addComment']);
            }

            $json = $this->updateFile($json, $path.$fileName);
//            dd($json);
        }
        /*Ler ou criar novo arquivo*/
        else
        {
            if( file_exists($path.$fileName) )
            {
                $json = file_get_contents($path.$fileName);
            }
            else
            {
                $json = $this->getChildren($id);

//                //Adicionar comentários [coluna comment no banco] caso esta cidade tenha sido gerada de forma indireta ou manual
//                if( $addComment ){
//                    $json = $this->addComment($json, $paramns['addComment']);
//                }

                ( $generateFile ) ? $this->createFile($json, $path.$fileName) : false;
            }
        }

        return json_decode($json, true);
    }

    protected function addComment($json, $comment){
        $json = json_decode($json, true);
        $comment = json_encode($comment);
        foreach ($json['geonames'] as &$city){
            $city['comments'] = $comment;
        }

        return $json;
    }

    protected function getChildren($id, $paramns = [])
    {
        $paramns['method'] = $paramns['method'] ?? 'children';
        //Geonames Children REST
        if ( $paramns['method'] == 'children' )
        {
            $service_url = "http://api.geonames.org/childrenJSON?geonameId=$id&username=$this->username&style=full&lang=pt&maxRows=20000";
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $service_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $curl_response = curl_exec($curl);
            curl_close($curl);

            return $curl_response;
        }
        else if( $paramns['method'] == 'search' )
        {
            $countyName     = $paramns['force']['countyName'];
            $countryCode    = $paramns['force']['countryCode'];

            $service_url = "http://api.geonames.org/searchJSON?q=$countyName&country=$countryCode&featureCode=PPL&maxRows=1000&style=long&lang=pt&orderBy=population&inclBbox=true&username=$this->username";
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $service_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $curl_response = curl_exec($curl);
            curl_close($curl);

            return $curl_response;
        }
        else
        {
            throw new \Error('Não existe "Method" [search || children]');
//            return false;
        }
    }

    protected function createFile($json_string, $path)
    {
        //converter para json e inserir data de criação
        $curl_response = json_decode($json_string, true);
        $curl_response['created_at'] = time();

        $content = json_encode($curl_response); //converter novamente para string json

        $fp = fopen($path, "x+");
        fwrite($fp,$content);
        fclose($fp);
    }

    protected function updateFile($newData, $file_path)
    {
        if (gettype($newData) != 'array') {
            $newData = json_decode($newData, true);
        }
        $itens = $newData['geonames'];

        $fullCurrentJson = json_decode(file_get_contents($file_path), true);
        $currData = $fullCurrentJson['geonames'];

//        dd($newData);
        foreach ($itens as $item)
        {
            array_push($currData, $item);
        }

        $fullCurrentJson['totalResultsCount'] = (int)$fullCurrentJson['totalResultsCount'] + (int)$newData['totalResultsCount'];

        $updateMessage = ['date' => time(), 'message' => 'Atualização para carregar as cidades dos condados'];
        if ( !isset($fullCurrentJson['updates']) ) {
            $fullCurrentJson['updates'] = [];
        }

        array_push($fullCurrentJson['updates'], $updateMessage);

        //$fullCurrentJson['update'] = ['date' => time(), 'message' => 'Atualização para carregar as cidades dos condados'];
        $fullCurrentJson['geonames'] = $currData;

//        dd($fullCurrentJson);
        $json = json_encode($fullCurrentJson);

        //dd($currData);
        $fp = fopen($file_path, "w+");
        fwrite($fp,$json);
        fclose($fp);

        return $json;
        //echo json_encode()
    }
}
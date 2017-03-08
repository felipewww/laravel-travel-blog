<?php

namespace App\Http\Controllers\Painel\World;

use App\City;
use App\Country;
use App\Continent;
use App\Library\DataTablesInterface;
use \App\Http\Controllers\Controller;


class CountriesController extends Controller implements DataTablesInterface {

    use \App\Library\Jobs, \App\Library\DataTablesExtensions;

//    private     $model;
    public      $continents;
    public      $countries;

    protected   $countries_json;
    protected   $datatables_columns;

    public function __construct()
    {
        $this->model = new Country();

        $this->continents = Continent::orderBy('name')->get();
        $this->countries = $this->model->all();

        $this->dataTablesInit();

        $this->vars['modulo'] = 'Pais';
        $this->vars['pageDesc'] = 'Listagem de Países';
        $this->vars['continents'] = $this->continents;

//        $allCities = City::select('id','name', 'status')->get();
//        $citiesCols = CityController::$cities_cols;

        //Adicionar coluna de STATUS. mudar o padrão de leitura de cidade.
//        array_splice($citiesCols, 3, 0, [
//            [
//                'title' => 'status',
//                'rowCallback' => ['func' => 'country.changeRegisteredCityStatus']
//            ]
//        ]);


        $activeCountries = new \stdClass();
        $activeCountries->countries = $this->model->select('id','name', 'content_regions')->where(['status' => 1])->whereNotNull('content_regions')->get();

        $activeCountries = $this->dataTablesConfig($activeCountries);
        $this->vars['activeCountries'] = $activeCountries;


//        CityController::
//        $activeCities = [
//            'data_info' => CityController::dataTables($allCities, 'onlyRegistered'),
//            'data_cols' => $citiesCols
//        ];
//
//        $this->vars['activeCities'] = $activeCities;

        //$activeCountries->countries = $this->model->select('id','name', 'content_regions')->where(['status' => 1])->whereNotNull('content_regions')->get();
//        $activeCities = CityController::activeCitiesDataTables()->asd();
        $ac = new CityController();
        $this->vars['activeCities'] = $ac->activeCities()->toTable();
    }

    /*
     * @rowButtons - Botões de ação que são inseridos na última coluna de uma tabela. Ações específicas do registro.
     * */
    function dataTablesConfig($returns = null)
    {
        if ( $returns instanceof \stdClass) {
            $countryList = $returns->countries;
            $returns->return = true;
        }else{
            $countryList = $this->countries;
        }

        $data = [];
        $i = 1;

        foreach ($countryList as $country)
        {
//            dd($country);
            if ( !empty($country->content_regions) ) {
                $pag = 'editar página';
                $cl = 'has';
            }else{
                $pag = '+ página';
                $cl = '';
            }

            $friendlyName = $ascii = $this->_toAscii($country->name);
            $cInfo = [
                $i,
                $country->id,
                $country->name,
                [
                    'rowButtons' =>
                        [
                            [
                                'html' => '+ config',
                                'attributes' => ['class' => 'sendPost', 'href' => "pais/$country->id"]
                            ],
                            [
                                'html' => $pag,
                                'attributes' => [
                                    'class' => 'sendPost'.' '.$cl,
//                                    'href' => "/pais/$friendlyName/$country->id",
                                    //'data-jslistener-click' => 'country.createCountryPage',
                                    'href' => '/painel/mundo/pais/single/'.$country->id,
                                    'target' => '_blank'
                                ]
                            ],
//                            [
//                                'html' => '+ post',
//                                'attributes' => [
//                                    'class' => 'sendPost',
////                                    'href' => "/pais/$friendlyName/$country->id",
//                                    'data-jslistener-click' => 'country.createCountryPost',
//                                    'target' => '_blank'
//                                ]
//                            ]
                        ]
                ]
            ];
            array_push($data,$cInfo);
            $i++;
        }

        if ( !isset($returns->return) ) {
            $this->data_info = $data;

            $this->data_cols = [
                ['title' => 'n', 'width' => '10px'],
                ['title' => 'id', 'width' => '70px'],
                ['title' => 'nome'],
                ['title' => 'ações', 'width' => '150px'],
            ];
        }else{
            return [
                'data_info' => $data,
                'data_cols' => $this->data_cols
            ];
        }

        return false;
    }

    function display()
    {
        return view('Painel.world.countries', $this->vars);
    }
}

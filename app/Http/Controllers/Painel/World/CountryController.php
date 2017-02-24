<?php

namespace App\Http\Controllers\Painel\World;

use \App\Http\Controllers\Controller;
use App\Library\BlogJobs;
use App\Library\DataTablesExtensions;
use App\Library\DataTablesInterface;
use App\Library\Headlines;
use App\Library\Jobs;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Http\Request;
use Lib\Geonames;
use App\City;
use App\Country as Country;
use App\Estate;

class CountryController extends Controller implements DataTablesInterface{

    use Jobs;
    use DataTablesExtensions;
    use Headlines{
        Headlines::__construct as Headlines;
    }

    use BlogJobs {
        BlogJobs::__construct as BlogJobsConstructor;
    }

    public      $estates;
    public      $geonames;
    public      $estates_db;
    public      $ids_db = [];

    public $cities_cols = [
        ['title' => 'n', 'width' => '10px'],
        ['title' => 'id', 'width' => '70px'],
        ['title' => 'nome'],
        ['title' => 'ações', 'width' => '200px'],
    ];

    public function __construct($countryId = 0)
    {
        $this->getReg(Country::class, $countryId);
//        $this->model = new Country();
//        $this->reg = $this->model->where('id', $countryId)->first();
        $this->geonames = new Geonames();
    }

    public function createOrUpdateCountryPage($request){
        $content = json_encode($request->content_regions, JSON_UNESCAPED_UNICODE);

        $this->reg->content_regions = $content;
        $this->reg->save();

        $data = ['status' => true];
        $res = [
            'return' => json_encode($data)
//            'return' => view('Site.world.country2', $this->vars)
        ];

        return $res;
    }

    public function display()
    {
        $this->hasAction(Request::capture());

        $this->Headlines(Country::class);

        $this->vars['modulo'] = 'País';
        $this->vars['pageDesc'] = 'Configurações do País: '.$this->reg['name'];

        $this->vars['country'] = $this->reg;
        $this->json_meta(['country' => $this->reg]);

        /*
         * Pegar estados que ja estão cadastrados no banco e inserir o ID deles num array para comparação futura na hora de montar
         * o datatable
         * */
        $estatesModel = new Estate();
        $this->estates_db = $estatesModel->where('countries_id', $this->reg->id)->get();
        foreach ($this->estates_db as $estate)
        {
            array_push($this->ids_db, $estate->id);
        }

        /*
         * Pegar estados do arquivo JSON
        */
        $this->estates = $this->geonames->children('estates', $this->reg['name'], $this->reg['id'])['geonames'];
        $this->json_meta(['estates' => $this->estates]);

        $this->BlogJobsConstructor();

        $this->vars['posts'] =
            BlogJobs::manage(
                $this->reg->Posts,
                [
                    'author_id' => function($post, $author_id){
                        $this->nullAuthor($post, $author_id);
                    }
                ]
            );

        $this->dataTablesInit();
        return view('Painel.world.country', $this->vars);
    }

    public function siteView(){
        $act = $this->hasAction(Request::capture());

        if ( $act['return'] != false ) {
            return $act['return'];
        }

        $c = new \App\Http\Controllers\Site\World\CountryController($this->reg->id);
        return $c->view();
    }

    public function deactive(){
        $this->reg->status = false;
        $this->reg->save();
    }

    public function active(){
        $this->reg->status = true;
        $this->reg->save();
    }

    function dataTablesConfig()
    {
        $data = [];
        $i = 1;

        foreach ($this->estates as $estate)
        {
            $regId = $estate['geonameId'];
            $friendlyName = $this->_toAscii($estate['name']);

            $s = array_search($regId, $this->ids_db);
            if ($s !== false){
                $citiesButton = [
                    'html' => '+ cidades',
                    'attributes' => ['class' => 'hasCityWithPost', 'data-jslistener-click' => 'country.findCities']
                ];
            }else{
                $citiesButton = [
                    'html' => '+ cidades',
                    'attributes' => ['data-jslistener-click' => 'country.findCities']
                ];
            }

            $cInfo = [
                $i,
                $regId,
                $estate['name'],
                [
                    'rowButtons' =>
                    [
                        $citiesButton,
                    ],
                    'anotherObject' => 'onlyTest'
                ],
                [ 'anotherObject' => 'onlyTest' ]
            ];
            array_push($data,$cInfo);
            $i++;
        }

        $this->data_info = $data;

        $this->data_cols = [
            ['title' => 'n', 'width' => '10px'],
            ['title' => 'id', 'width' => '70px'],
            ['title' => 'nome'],
            ['title' => 'ações', 'width' => '85px'],
        ];
    }

    public function readCitiesApi($request)
    {
        $cities = $this->geonames->children('cities', $request->name, $request->id)['geonames'];
//        $json = json_encode($this->makeButtons($cities, $request->all()));
        $json = json_encode( CityController::dataTables($cities, $request->all()));

        return ['dataSource' => $json, 'cols' => CityController::$cities_cols];
    }

    /*
     * $request->id (ID do ESTADO)
     * $request->county_id (ID do CONDADO)
     *
     * Surgiu a necessidade de cadastrar cidades a partir de CONDADOS (Ex: Orlando [condado: Orange Estate: Flórida]).
     *
     * Como no mundo existem muitas cidades assim, esse trabalho deve ser feito conforme a necessidade
     * via JS "master.countryInfo.readCityFromCounty()"
     * */
    public function readCountyCitiesApi($request)
    {
//        dd($request->all());
        $paramns = [];

        $paramns['generateFile'] = false;
        $paramns['updateFile'] = true;

        $paramns['getChildrenFromThisId'] = $request->county_id;
        $paramns['addComment'] = [
            'county_id' => $request->county_id, //ID da cidade, que na verdade é um condado
            'message' => 'Está é uma cidade de um Condado criado manualmente por "master.countryInfo.readCityFromCounty()" .'
        ];

        $paramns['force'] = $request->force;
        $paramns['isTest'] = $request->isTest;

        $paramns['method'] = ( $request->force == 'false' ) ? 'children' : 'search';

        $cities = $this->geonames->children('cities', $request->estate, $request->id, $paramns);
//        $json = json_encode($this->makeButtons($cities['geonames'], $request->all()));
        $json = json_encode( CityController::dataTables( $cities['geonames'], $request->all() ) );
//        dd($json);
        return ['dataSource' => $json, 'cols' => CityController::$cities_cols];
    }

//    protected function makeButtons($cities, $request)
//    {
//        $json = [];
//
//        //Cidades deste ESTADO que ja estão cadastradas no banco
//        $cities_ids_db = [];
//        $cities_db = City::where('estates_id', $request['id'])->get();
//
//        foreach ($cities_db as $city)
//        {
//            array_push($cities_ids_db, $city->id);
//        }
//
//        $i = 1;
//        foreach ($cities as $city)
//        {
//            $regId = $city['geonameId'];
//
//            $s = array_search($regId, $cities_ids_db);
//            $friendlyName = $this->_toAscii($city['name']);
//
//            if ( $s !== false ) {
//                $pagePostButton = [
//                    'html' => 'editar página',
//                    'attributes' => [
//                        'class' => 'hasPost',
//                        'href' => "/painel/mundo/cidade/single/$regId",
//                        'target' => '_blank'
//                    ]
//                ];
//
//                $blogPostButton = [
//                    'html' => '+ post',
//                    'attributes' => [
//                        'href' => '/painel/blog/novo-post/cidade/'.$regId,
//                        'target' => '_blank'
//                    ]
//                ];
//
//                $configButton = [
//                    'html' => '+ config',
//                    'attributes' => [
//                        'href' => '/painel/mundo/cidade/'.$regId
//                    ]
//                ];
//            }else{
//                $jsonData = ['estate_id' => $request['id'], 'city' => $city];
//                $pagePostButton = [
//                    'html' => 'criar página',
//                    'attributes' => [
//                        'class' => 'createPage',
//                        'data-action' => '/painel/mundo/cidade/single',
//                        'data-post' => json_encode($jsonData),
//                        'onclick' => 'country.createCityPage(this)',
//                    ]
//                ];
//                $blogPostButton = [
//                    'html' => '+ post',
//                    'attributes' => [
//                        'data-action' => '/painel/blog/post/cidade',
//                        'data-post' => json_encode($jsonData),
//                        'onclick' => 'country.createCityPage(this)',
//                    ]
//                ];
//                $configButton = [
//                    'html' => '+ config',
//                    'attributes' => [
//                        'class' => 'disabled',
//                        'href' => 'javascript:;',
//                        'data-jslistener-click' => 'country.beforeConfig'
//                    ]
//                ];
//            }
//
//            $data               = [
//                $i,
//                $regId,
//                $city['name'],
//                [
//                    'rowButtons' =>
//                        [
//                            $configButton,
//                            $pagePostButton,
//                            $blogPostButton,
//                        ]
//                ]
//            ];
//            array_push($json, $data);
//            $i++;
//        }
//
//        return $json;
//    }
}

<?php

namespace App\Http\Controllers\Painel\World;

//use App\Library\Jobs;
//use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;
use App\Library\DataTablesExtensions;
use App\Library\DataTablesInterface;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Input;
use Lib\Geonames;
use Painel\World\City;
use \Painel\World\Country as Country;
use Painel\World\Estate;

class CountryInfoController extends Controller implements DataTablesInterface {

    use \App\Library\Jobs;
    use DataTablesExtensions;

    protected   $vars = [];
    protected   $model;
    public $country;
    public $estates;
    public $geonames;

    public function __construct(Country $model, Request $request)
    {
        $this->model = $model;
        $this->geonames = new Geonames();
    }

    function dataTablesConfig()
    {
        $data = [];
        $i = 1;

        //Criar objeto json para entendimento da função Script.createElement();
        //Funciona para criar botões padrão
//        $this->add
//        ([
//            'html' => '+ post',
//            'attributes' => ['class' => 'sendPost', 'action' => 'painel/mundo/pais/info', 'data-jslistener-click' => 'country.createPost']
//        ])->add
//        ([
//            'html' => '+ cidades',
//            'attributes' => ['data-jslistener-click' => 'country.findCities']
//        ]);

        foreach ($this->estates as $estate)
        {
            $regId = $estate['id'] ?? $estate['geonameId'];
            $cInfo = [
                $i,
                $regId,
                $estate['name'],
                [
//                    'rowButtons' => $this->tableButtons,
                    'rowButtons' =>
                    [
                        [
                            'html' => '+ post',
                            'attributes' => ['data-jslistener-click' => 'country.createPost']
                        ],
                        [
                            'html' => '+ cidades',
                            'attributes' => ['data-jslistener-click' => 'country.findCities']
                        ],
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
            ['title' => 'ações', 'width' => '130px'],
        ];
    }

    public function display($id)
    {
        $this->country = $this->model->find($id)->getAttributes();

        $this->vars['country'] = $this->country;
        //$geonames = new Geonames();

        //TODO - primeiro tentar encontrar no banco... depois arquivo json

        $this->estates = $this->geonames->children('estates', $this->country['name'], $this->country['id'])['geonames'];

        $this->dataTablesInit();

        return view('Painel.world.countryInfo', $this->vars);
    }

    function readCities($request)
    {
        //Datatables
        $json = [];
        //$json['dataSource'] = [];
        $cols = [
            ['title' => 'n', 'width' => '10px'],
            ['title' => 'id', 'width' => '70px'],
            ['title' => 'nome'],
            ['title' => 'ações', 'width' => '70px'],
        ];

        //Se o estado ja estiver salvo no banco. Significa que todos os estados e cidades deste pais também estão
        $estate = Estate::find($request->id);
        if ($estate)
        {
            $from = 'db';
            $idFiled = 'id';
            $cities = City::where('estates_id', $request->id)->orderBy('name')->get();
        }
        else
        {
            $from = 'json';
            $idFiled = 'geonameId';
            $cities = $this->geonames->children('cities', $request->name, $request->id)['geonames'];
        }

        $i = 0;
        foreach ($cities as $city)
        {
            if ($from == 'db') {
                    $city = $city->getAttributes();
            }

            $data               = [
                $i+1,
                $city[$idFiled],
                $city['name'],
                [
                    'rowButtons' =>
                    [
                        [
                            'html' => '+ post',
                            'attributes' => ['data-jslistener-click' => 'country.createCityPost']
                        ]
                    ]
                ]
            ];
            array_push($json, $data);
        }


        $json = json_encode($json);

        $res = ['dataSource' => $json, 'cols' => $cols];

        return $res;
    }
}

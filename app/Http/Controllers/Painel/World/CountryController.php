<?php

namespace App\Http\Controllers\Painel\World;

use \App\Http\Controllers\Controller;
use App\Library\BlogJobs;
use App\Library\Headlines;
use App\Library\Jobs;
use Illuminate\Http\Request;
use App\Country as Country;
use Lib\Geonames;

class CountryController extends Controller {

    use Jobs;

    use Headlines{
        Headlines::__construct as Headlines;
    }

    use BlogJobs {
        BlogJobs::__construct as BlogJobsConstructor;
    }

    public      $geonames;
    public      $ids_db = [];
    public $cities;

    public $cities_cols = [
        ['title' => 'n', 'width' => '10px'],
        ['title' => 'id', 'width' => '70px'],
        ['title' => 'nome'],
        ['title' => 'ações', 'width' => '200px'],
    ];

    public function __construct($countryId = 0)
    {
        $this->getReg(Country::class, $countryId);
        $this->geonames = new Geonames();
    }

    public function _readCities()
    {
        $this->cities = $this->reg->Cities;

        $finalInfo = [];
        $i = 1;
        foreach ($this->cities as $city)
        {
            $citiesButtons = [
                [
                    'html' => '+ config',
                    'attributes' =>[
                        'href' => '/painel/mundo/cidade/'.$city->id,
                    ]
                ],
                [
                    'html' => '+ pagina',
                    'attributes' =>[
                        'href' => '/painel/mundo/cidade/single/'.$city->id,
                    ]
                ],
                [
                    'html' => '+ post',
                    'attributes' =>[
                        'href' => '/painel/blog/novo-post/cidade/'.$city->id,
                    ]
                ],
            ];

            $cityInfo = [
                $i,
                $city->id,
                $city->name,
                $city->status,
                [
                    'rowButtons' => $citiesButtons,
                ],
            ];

            array_push($finalInfo,$cityInfo);
            $i = $i+1;
        }

        $this->vars['cities'] = [
            'data' => json_encode($finalInfo),
            'cols' => json_encode([
                ['title' => 'n', 'width' => '10px'],
                ['title' => 'id', 'width' => '70px'],
                ['title' => 'nome'],
                [
                    'title' => 'status',
                    'width' => '100px',
                    'rowCallback' => ['func' => 'country.changeRegisteredCityStatus']
                ],
                ['title' => 'ações', 'width' => '200px'],
            ])
        ];
    }

    public function createOrUpdateCountryPage($request){
        $content = json_encode($request->content_regions, JSON_UNESCAPED_UNICODE);

        $this->reg->content_regions = $content;
        $this->reg->save();

        $data = ['status' => true];
        $res = [
            'return' => json_encode($data)
        ];

        return $res;
    }

    public function display()
    {
        $this->hasAction(Request::capture());
        $this->_readCities();
        $this->Headlines(Country::class);

        $this->vars['modulo'] = 'País';
        $this->vars['pageDesc'] = 'Configurações do País: '.$this->reg['name'];

        $this->vars['country'] = $this->reg;
        $this->json_meta(['country' => $this->reg]);


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

    public function findACityApi($name, $countryIso)
    {
        $cities = $this->geonames->findACity($name, $countryIso)['geonames'];
        $json = json_encode( CityController::_dataTables($cities) );
        return ['dataSource' => $json, 'cols' => CityController::$cities_cols];
    }
}

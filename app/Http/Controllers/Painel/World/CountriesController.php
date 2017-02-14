<?php

namespace App\Http\Controllers\Painel\World;

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
    }

    /*
     * @rowButtons - Botões de ação que são inseridos na última coluna de uma tabela. Ações específicas do registro.
     * */
    function dataTablesConfig()
    {
        $data = [];
        $i = 1;

        foreach ($this->countries as $country)
        {
            $friendlyName = $ascii = $this->toAscii($country->name);
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
                                'html' => '+ página',
                                'attributes' => [
                                    'class' => 'sendPost',
//                                    'href' => "/pais/$friendlyName/$country->id",
                                    'data-jslistener-click' => 'country.createCountryPage',
                                    'target' => '_blank'
                                ]
                            ],
                            [
                                'html' => '+ post',
                                'attributes' => [
                                    'class' => 'sendPost',
//                                    'href' => "/pais/$friendlyName/$country->id",
                                    'data-jslistener-click' => 'country.createCountryPost',
                                    'target' => '_blank'
                                ]
                            ]
                        ]
                ]
            ];
            array_push($data,$cInfo);
            $i++;
        }

        $this->data_info = $data;

        $this->data_cols = [
            ['title' => 'n', 'width' => '10px'],
            ['title' => 'id', 'width' => '70px'],
            ['title' => 'nome'],
            ['title' => 'ações', 'width' => '170px'],
        ];
    }

    function display()
    {
        return view('Painel.world.countries', $this->vars);
    }
}

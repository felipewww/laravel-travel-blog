<?php

namespace App\Http\Controllers\Painel\World;

use App\Library\DataTablesInterface;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;
use \Painel\World\Country as Country;

class CountryController extends Controller implements DataTablesInterface {

    use \App\Library\Jobs, \App\Library\DataTablesExtensions;

    private     $model;
    public      $continents;
    public      $countries;

    protected   $countries_json;
    protected   $datatables_columns;

    protected   $vars = [];

    public function __construct(Country $model)
    {
        $this->model = $model;
        $this->continents = \Painel\World\Continent::orderBy('name')->get();
        $this->countries = Country::all();

        $this->dataTablesInit();

        $this->vars['continents'] = $this->continents;
    }

    /*
     * @rowButtons - Botões de ação que são inseridos na última coluna de uma tabela. Ações específicas do registro.
     * */
    function dataTablesConfig()
    {
        $data = [];
        $i = 1;

        //Criar objeto json para entendimento da função Script.createElement();
        $this->add
        ([
            'html' => 'edit',
            'attributes' => ['class' => 'sendPost', 'action' => 'painel/mundo/pais/info']
        ]);

        foreach ($this->countries as $country)
        {
            $cInfo = [
                $i,
                $country->id,
                $country->name,
                [
                    'rowButtons' => $this->tableButtons
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
            ['title' => 'ações'],
        ];
    }

    function display()
    {
        return view('Painel.world.country', $this->vars);
    }

    function store(Request $request)
    {
        $this->model->store( $request->all() );
        $this->vars['status'] = 'success';
        return view('Painel.world.country', $this->vars);
    }
}

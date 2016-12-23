<?php

namespace App\Http\Controllers\Painel\World;

use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;
use \Painel\World\Country as Country;

class CountryController extends Controller
{
    private $post;
    public $continents;
    public $countries;

    protected $countries_json;
    protected $datatables_columns;

    public function __construct(Country $post)
    {
        $this->post = $post;
        $this->continents = \Painel\World\Continent::orderBy('name')->get();
        $this->countries = Country::all();
        $this->dataTablesSetup();
    }

    function dataTablesSetup()
    {
        $data = [];
        $i = 1;
        foreach ($this->countries as $country)
        {
            $cInfo = [
                $i,
                $country->id,
                $country->name,
                null
            ];
            array_push($data,$cInfo);
            $i++;
        }

        $this->countries_json = $data;
        $this->datatables_columns = [
            ['title' => 'n', 'width' => '10px'],
            ['title' => 'id', 'width' => '70px'],
            ['title' => 'nome'],
            ['title' => 'ações'],
        ];
    }

    function dataTablesActionButtons()
    {
        $act = '<span>act 1</span>';
        //$act .= '<span>act 2</span>';
        //$act .= '<span>act 3</span>';
        $act  = "test";
        return $act;
    }

    function display()
    {
        return view('Painel.world.country',
            [
                'continents' => $this->continents,
                'countries' => json_encode($this->countries_json),
                'dataTables_columns' => json_encode($this->datatables_columns)
            ]
        );
    }

    function store(Request $request)
    {
        $this->post->store( $request->all() );

        return view('Painel.world.country',
            [
                'continents' => $this->continents,
                'status' => 'success',
                'countries' => $this->countries
            ]
        );

    }
}

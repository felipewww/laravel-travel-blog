<?php

namespace App\Http\Controllers\Painel\World;

use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;
use \Painel\World\Country as Country;
//use app\Http\Controllers\Painel\World\Country;

class CountryController extends Controller
{
    private $post;
    public $continents;

    public function __construct(Country $post)
    {
        $this->post = $post;
        $this->continents = \Painel\World\Continent::orderBy('name')->get();
    }

    function display($x = false)
    {
        if ($x){
            echo 'from exceptions';
        }
        return view('Painel.world.country', ['continents' => $this->continents]);
    }

    function store(Request $request)
    {
        $this->post->store( $request->all() );

        return view('Painel.world.country',
            [
                'continents' => $this->continents,
                'status' => 'success'
            ]
        );

    }
}

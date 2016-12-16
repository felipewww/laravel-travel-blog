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

    function display()
    {
        return view('Painel.world.country', ['continents' => $this->continents, 'status' => 'none']);
    }

    function displayPost(Request $request)
    {
        //print_r($request->all());
//        echo $request->name;
//        dd($this->post->create($request->all()));
        $status = $this->post->testCreate($request->all());

        //if ($status){}
        return view('Painel.world.country', ['continents' => $this->continents, 'status' => $status]);
    }
}

<?php

namespace App\Http\Controllers\Painel\World;

use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;
use \Painel\World\Country as Country;
//use app\Http\Controllers\Painel\World\Country;

class CountryController extends Controller
{
    private $post;

    public function __construct(Country $post)
    {
        $this->post = $post;
    }

    function display()
    {
        $continents = \Painel\World\Continent::orderBy('name')->get();

        return view('Painel.world.country', ['continents' => $continents]);
    }

    function displayPost(Request $request)
    {
//        print_r($request->all());
//        echo $request->name;
        dd($this->post->create($request->all()));

        return view('Painel.world.country');
    }
}

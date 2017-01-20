<?php

namespace App\Http\Controllers\Site\World;

use App\Http\Controllers\Controller;
use App\Library\Jobs;
//use Illuminate\Http\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Painel\World\City;
use Painel\World\Continent;
use Painel\World\Country;
use Painel\World\Estate;

class CityController extends Controller {
    use Jobs;

    function index(){
        return view('Site.world.city', ['isAdmin' => Auth::check()]);
    }

    function index2(Request $request){
        $this->json_meta($request->all());

//        dd($request->all());

        $continent = Continent::where('id', $request['country']['continents_id'])->first();

        $this->vars['isAdmin'] = Auth::check();
        $this->vars['isNew'] = true;

        $this->vars['continent'] = $continent;
        $this->vars['country'] = $request['country'];
        $this->vars['estate'] = $request['estate'];
        $this->vars['city'] = $request['city'];

        return $this->blogView();
    }

    function index3(Request $request){
        $this->vars['isNew'] = false;
        $this->vars['isAdmin'] = Auth::check();

        $city = City::where('id', $request->id)->first();
        $estate = Estate::where('id', $city->estates_id)->first();
        $country = Country::where('id', $estate->countries_id)->first();
        $continent = Continent::where('id',$country->continents_id)->first();

        $this->vars['continent'] = $continent;
        $this->vars['country'] = $country;
        $this->vars['estate'] = $estate;
        $this->vars['city'] = $city;

        return $this->blogView();
    }

    protected function blogView(){
        return view('Site.world.city', $this->vars);
    }
}
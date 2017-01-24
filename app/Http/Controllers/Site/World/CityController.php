<?php

namespace App\Http\Controllers\Site\World;

use App\Http\Controllers\Controller;
use App\Library\Jobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\City;
use App\Continent;
use App\Country;
use App\Estate;

class CityController extends Controller {
    use Jobs;

    /*
     * Read city from JSON
     * */
    function forCreate(Request $request){
        $this->json_meta($request->all());
        $this->json_meta(['contentToolsOnSave' => 'city.create']);

        $continent = Continent::where('id', $request['country']['continents_id'])->first();

        $this->vars['isAdmin'] = Auth::check();
        $this->vars['isNew'] = true;

        $this->vars['continent'] = $continent;
        $this->vars['country'] = $request['country'];
        $this->vars['estate'] = $request['estate'];
        $this->vars['city'] = $request['city'];

        return $this->blogView();
    }

    /*
     * Read City from DB
     * */
    function fromDB(Request $request){

        $mw = $request->route()->middleware();
        $mw = $mw[count($mw)-1];

        $this->vars['isNew'] = false;
        $this->vars['isAdmin'] = Auth::check() && $mw == 'auth';
        $this->json_meta(['contentToolsOnSave' => 'city.update', 'city_id' => $request->id]);

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
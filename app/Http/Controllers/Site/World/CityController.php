<?php

namespace App\Http\Controllers\Site\World;

use App\Http\Controllers\Controller;
use App\Library\Jobs;
use App\Library\WorldEstructureJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\City;
use App\Continent;
use App\Country;
use App\Estate;

class CityController extends Controller {
    use Jobs;
    use WorldEstructureJobs;

    /*
     * Read city from JSON
     * Apenas quando esta criando cidade via painel administrativo
     * */
    function forCreate(Request $request){
        $this->json_meta($request->all());
        $this->json_meta(['contentToolsOnSave' => 'city.create']);

        $this->vars['isAdmin'] = Auth::check();
        $this->vars['isNew'] = true;

        $this->getEstructureBreadcrumb('city', $request);
        $this->vars['city'] = $request['city'];

        return $this->cityPageView();
    }

    /*
     * Read City from DB
     * Para edição da página de cidade via painel ou exibição do Site
     * */
    function fromDB(Request $request){

        $mw = $request->route()->middleware();
        $mw = $mw[count($mw)-1];

        $this->vars['isNew'] = false;
        $this->vars['isAdmin'] = Auth::check() && $mw == 'auth';
        $this->json_meta(['contentToolsOnSave' => 'city.update', 'city_id' => $request->id]);

        $city = City::where('id', $request->id)->first();
        $this->vars['city'] = $city;

        return $this->cityPageView();
    }

    protected function cityPageView(){
        return view('Site.world.city', $this->vars);
    }
}
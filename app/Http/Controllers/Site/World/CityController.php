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
    function __construct($id)
    {
        $this->getReg(City::class, $id);
    }

    /*
     * Read City from DB
     * Para edição da página de cidade via painel ou exibição do Site
     * */
    function readCity(Request $request){
        if ( $act = $this->hasAction($request) ) {
            return $act;
        }

        $isAdmin = Auth::check();
        $this->vars['isAdmin'] = $isAdmin;

        $city = City::where('id', $request->id)->first();

//        $this->getEstructureBreadcrumb('city', $city);

        $this->vars['isNew'] = false;

        $this->json_meta(['contentToolsOnSave' => 'city.update', 'city_id' => $request->id]);
        $this->reg->content_regions = json_decode($this->reg->content_regions, true);

//        $this->vars['city'] = $city;

        if ( !isset($city->content_regions['article_content']) )
        {
            if ($isAdmin)
            {
                return $this->cityPageView();
            }
            else
            {
                return view('Site.404', $this->vars);
            }
        }
        else
        {
                return $this->cityPageView();
        }
    }

    /*
     * Update city page
     * */
    protected function update($request){
        $controller = new \App\Http\Controllers\Painel\World\CityController($this->reg);
        return $controller->updatePage($request);
    }

    protected function cityPageView(){
        return view('Site.world.city', $this->vars);
    }
}
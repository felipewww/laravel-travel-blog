<?php

namespace App\Http\Controllers\Site\World;

use App\Country;
use App\Http\Controllers\Controller;
use App\Library\Jobs;
use App\Library\WorldEstructureJobs;
use Illuminate\Support\Facades\Auth;

class CountryController extends Controller {
    use Jobs;
    use WorldEstructureJobs;

    public function __construct($id)
    {
        $this->getReg(Country::class, $id);
    }

    public function view()
    {
//        $act = $this->hasAction($request);
//
//        if ( $act['return'] != false ) {
//            return $act['return'];
//        }

        $isAdmin = Auth::check();
        $this->vars['isAdmin'] = $isAdmin;


        $this->getEstructureBreadcrumb('country', $this->reg);
        $this->json_meta(['contentToolsOnSave' => 'country.createOrUpdateCountryPage']);

        $this->reg->content_regions = json_decode($this->reg->content_regions, true);
        $this->vars['reg'] = $this->reg;

        if ( !isset($this->reg->content_regions['article_content']) )
        {
            if ($isAdmin)
            {
                return $this->pageView();
            }
            else
            {
                return view('Site.404', $this->vars);
            }
        }
        else
        {
            return $this->pageView();
        }
    }

    public function pageView()
    {
        return view('Site.world.country', $this->vars);
    }
}
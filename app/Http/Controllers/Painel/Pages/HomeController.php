<?php

namespace App\Http\Controllers\Painel\Pages;

use App\Home;
use \App\Http\Controllers\Controller;
use App\Library\Jobs;

class HomeController extends Controller {

    use Jobs;
    public $homeModel;
    public $home;
    public $headlines;

    public function __construct()
    {
//        $this->json_meta(['city_id' => $cityId]);
        $arr = [
            'id',
            'name',
            'estates_id',
            'status',
            'comments',
            'search_tags',
            'seo_tags',
            'created_at',
            'updated_at',
            'cities_photos_id',
            'lat',
            'lng',
        ];

        $this->homeModel    = new Home();
//        $this->id       = $id;
//        $this->reg      = $this->model->select($arr)->where('id', $id)->first();
    }

    public function getHome($id){
        $this->home = $this->homeModel->find($id);
        $this->headlines = $this->home->headline;

        $this->vars['home']         = $this->home;
        $this->vars['headlines']    = $this->headlines;

        //Para criar um manyHeadline

        /*
         * $headline = App\Headline::find(1)
         * $home->headline()->attach($hl, ['position' => $pos]);
         *
         * para excluir...
         * $home->headline()->dettach($hl);
         *
         * para recarregar tudo - remove tudo e só poe os de baixo...
         * $home->headline()->sync($hl1, $hl2...);
         * */

    }

    public function display()
    {
        return view('Painel.pages.home', $this->vars);
    }
}

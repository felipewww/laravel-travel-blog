<?php

namespace App\Http\Controllers\Painel\World;

use \App\Http\Controllers\Controller;
use App\Http\Controllers\Painel\Blog\PostController;
use App\Interest;
use App\Library\BlogJobs;
use App\Library\Headlines;
use App\Library\Jobs;
use App\Library\photoGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\City;
use App\Estate;

class CityController extends Controller {

    use Jobs;

    use Headlines{
        Headlines::__construct as Headlines;
    }

    use photoGallery {
        photoGallery::__construct as photoGallery;
    }

//    public $model;
//    public $city;
    public $cityId;
    public $interests;
    public $allInterests;
    public $cityModel;

    public function __construct($cityId)
    {

        $this->json_meta(['city_id' => $cityId]);

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

        $this->model    = new City();
        $this->cityId   = $cityId;
        $this->reg = $this->model->select($arr)->where('id', $cityId)->first();
    }

    /*
     * Exemplo de como tratar os dados do registro na controller,
     * nesse caso, o tratamento na controller chama a função default de tratamento em BlogJobs.
     * */
    protected function nullAuthor($post, $id)
    {
        //Manter tratamento default e add outras coisas
        BlogJobs::author_id($post, $id);

        //Aqui podem vir outros tratamentos além do default...
    }

    public function deactive(){
        $this->reg->status = false;
        $this->reg->save();
    }

    public function active(){
        $this->reg->status = true;
        $this->reg->save();
    }

    public function display($request = '')
    {
        $this->hasAction($request);

        $this->Headlines(City::class);
        if ( empty($this->reg) ) {
            trigger_error('Cidade não encontrada no Banco de dados. Favor gerar via Painel Administrativo um "Blog/Post" ou criar a "Página da Cidade" para depois editar suas configurações', E_USER_ERROR);
        }

        $this->vars['places'] = $this->reg->Places;

        $this->vars['posts'] =
            PostController::manage(
                $this->reg->Posts,
                [
                    'author_id' => function($post, $author_id){
                        $this->nullAuthor($post, $author_id);
                    }
                ]
        );

        /*
         * Isso porque o CITY.JS é executado tanto no SITE para edição do post, quanto no painel para edição de
         * cofigurações, se for painel, o script CITY inicial de forma diferenciada.
         * */
        $this->json_meta(['isPainel' => true]);

//        dd($this->reg->interests);
//        $this->interests();
        $this->vars['interests'] = $this->interests;
        $this->vars['allInterests'] = Interest::all();

        $this->vars['reg'] = $this->reg;
//        $this->vars['reg'] = $this->reg->getAttributes();
        $this->vars['modulo'] = 'Cidade';
        $this->vars['pageDesc'] = 'Configurações da cidade: '.$this->reg->name;

        return view('Painel.world.city', $this->vars);
    }

    public function interests()
    {
        $this->interests = DB::table('city_has_interests as many')
            ->select('it.color', 'many.interest_id', 'it.name')
            ->join('interests as it', 'it.id', 'many.interest_id')
            ->where('many.city_id', $this->reg->id)
            ->get()
        ;

        $selecteds = [];
        foreach ($this->interests as $selected)
        {
            array_push($selecteds, $selected->interest_id);
        }

        $this->allInterests = Interest::all();
        foreach ($this->allInterests as &$all)
        {
            $all['checked'] = (array_search($all->id, $selecteds) !== false) ? 'checked="checked"' : '';
        }

        $this->vars['interests'] = $this->interests;
        $this->vars['allInterests'] = $this->allInterests;
    }

    /**
     * @paramn $city Informações da cidade vindas de um json request
     * @paramn $estate Informações do estado vindas de um json request
     * @paramn $country Informações do país vindas de um json request
     * @paramn $HTML Informações do país vindas de um json request
     * */
    public function create($city, $estate, $country, $html)
    {
        $hasEstate = Estate::where('id', $estate['geonameId'])->get()[0] ?? false;
        if ( !$hasEstate ) {
            $e = new Estate();

            $e->id              = $estate['geonameId'];
            $e->name            = $estate['name'];
            $e->countries_id    = $country['id'];

            //geonames as vezes não traz bbox.
            if ( isset($estate['bbox']) && !empty($estate['bbox']) )
            {
                $e->ll_north        = $estate['bbox']['north'];
                $e->ll_south        = $estate['bbox']['south'];
                $e->ll_east         = $estate['bbox']['east'];
                $e->ll_west         = $estate['bbox']['west'];
                $e->lat             = ($estate['bbox']['north']+$estate['bbox']['south'])/2;
                $e->lng             = ($estate['bbox']['east']+$estate['bbox']['west'])/2;
            }
            else
            {
                if ( isset($estate['lat']) && isset($estate['lgn']) ) {
                    $e->lat             = $estate['lat'];
                    $e->lng             = $estate['lng'];
                }
            }

            $e->save();
        }

        $this->model->id                = $city['geonameId'];
        $this->model->name              = $city['name'];
        $this->model->estates_id        = $estate['geonameId'];
        $this->model->content_regions   = $html;

        //geonames as vezes não traz bbox.
        if ( isset($city['bbox']) && !empty($city['bbox']) )
        {
            $this->model->ll_north        = $city['bbox']['north'];
            $this->model->ll_south        = $city['bbox']['south'];
            $this->model->ll_east         = $city['bbox']['east'];
            $this->model->ll_west         = $city['bbox']['west'];
            $this->model->lat             = ($city['bbox']['north']+$city['bbox']['south'])/2;
            $this->model->lng             = ($city['bbox']['east']+$city['bbox']['west'])/2;
        }
        else
        {
            if ( isset($city['lat']) && isset($city['lgn']) ) {
                $this->model->lat             = $city['lat'];
                $this->model->lng             = $city['lng'];
            }
        }

        return $this->model->save();
    }

    /**
     * Exemplo de sobreposição de método para cropar a imagem de form diferente da Default.
     */
//    protected function uploadHeadlineImage($img, $name = ''){
//        return $img = Jobs::uploadImage($img, 'Site/media/images/cidades/headlines',
//            [
//                'shape' => 'square',
//                'max-width' => 600,
//            ]
//        );
//    }

    public function createAjaxAction($request)
    {
        $data = $request['screen_json'];
        $content = json_encode($request['content_regions'], JSON_UNESCAPED_UNICODE);

        $this->create($data['city'], $data['estate'], $data['country'], $content);

        $res = [
            'status' => true
        ];
        return json_encode($res);
    }

    public function updateAjaxAction($request)
    {
        $city = $this->model->find($request->screen_json['city_id']);
        $currRegions = json_decode($city->content_regions, true);

        $edited = false;
        foreach($request->content_regions as $key => $region)
        {
            if ( isset($region['content']) ) {
                $edited = true;
                $currRegions[$key]['content'] = $region['content'];
            }
        };

        if ($edited) {
            $city->content_regions = json_encode($currRegions, JSON_UNESCAPED_UNICODE);
            $city->save();
        }

        $res = [
            'edited' => $edited,
            'status' => true
        ];

        return json_encode($res);
    }

    public function activateAjaxAction($request)
    {
        $city = $this->model->find($request['screen_json']['city']['geonameId']);
        $city->status = 1;
        $city->save();

        $res = [
            'status' => true,
            'ascii_name' => $this->_toAscii($city->name)
        ];

        return json_encode($res);
    }

    public function updateInterestsAjaxAction($request)
    {
        $table = 'city_has_interests';
        $interests = $request->ints;

        DB::table($table)->where('city_id', $this->cityId)->delete();

        foreach ($interests as $in){
            DB::table($table)->insert(
                [
                    'city_id' => $this->cityId,
                    'interest_id' => $in,
                ]
            );
        }

        return json_encode(['status' => true]);
    }

    public function updateTagsAjaxAction($request)
    {
        $this->reg->search_tags    = $request->system;
        $this->reg->seo_tags       = $request->seo;
        $this->reg->save();

        return json_encode(['status' => true]);
    }
}

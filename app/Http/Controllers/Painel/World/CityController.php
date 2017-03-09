<?php

namespace App\Http\Controllers\Painel\World;

use \App\Http\Controllers\Controller;
use App\Library\BlogJobs;
use App\Library\Headlines;
use App\Library\Interests;
use App\Library\Jobs;
use App\Library\photoGallery;
use App\City;
use App\Post;

class CityController extends Controller {

    public $activeCities;

    public static $cities_cols = [
        ['title' => 'n', 'width' => '10px'],
        ['title' => 'id', 'width' => '70px'],
        ['title' => 'nome'],
        ['title' => 'ações', 'width' => '200px'],
    ];

    use Jobs;

    use Headlines{
        Headlines::__construct as Headlines;
    }

    use photoGallery {
        photoGallery::__construct as photoGallery;
    }

    use Interests {
        Interests::__construct as Interests;
    }

    use BlogJobs {
        BlogJobs::__construct as BlogJobsConstructor;
    }

    public function __construct($cityId = 0)
    {
        $this->setDefaults();

        if ($cityId instanceof City) {
            $this->reg = $cityId;
        }
        //As vezes, a classe é instanciada somente para usar as configs default como $model e etc.
        else if ($cityId == 0) {
            return;
        }

        $this->selectColumns = [
            'id',
            'name',
            'status',
            'comments',
            'search_tags',
            'seo_tags',
            'created_at',
            'updated_at',
            'cities_photos_id',
            'lat',
            'lng',
            'country_id'
        ];

        $this->getReg(City::class, $cityId);
        $this->json_meta(['city_id' => $cityId]);
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
        $act = $this->hasAction($request);

        if ($act != false) {
//            dd($request->all());
            $PostMessage =  $act['message'];
            return redirect('/painel/mundo/cidade/'.$this->reg->id)->with('PostMessage',json_encode($PostMessage));
        }


        $this->Headlines(City::class);
        $this->Interests();
        $this->BlogJobsConstructor();
        $this->PhotoGallery(City::class);

        $this->vars['places'] = $this->reg->Places;

        $this->vars['posts'] =
            BlogJobs::manage(
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

        $this->vars['reg'] = $this->reg;
        $this->vars['modulo'] = 'Cidade';
        $this->vars['pageDesc'] = 'Configurações da cidade: '.$this->reg->name;

        return view('Painel.world.city', $this->vars);
    }

    public function _create($request)
    {
        $res = [ 'status' => true ];

        $reg = City::where('id', $request->id)->first();
        if ( !empty($reg) ) {

            $res = ['status' => false, 'message' => 'Esta cidade já está cadastrada no banco'];
            return json_encode($res);
        }

        $request['geoadmins'] = json_encode($request['geoadmins']);
        City::create($request->all());

        $res['message'] = 'ok';
        return json_encode($res);
    }

    public function updatePage($request)
    {
        $current = json_decode($this->reg->content_regions, true);
        $regions = $request['content_regions'];

        $edited = false;
        foreach ($regions as $regionName => $region)
        {
            //se existe, é porque foi alterado.
            if ( isset($region['content']) )
            {
                //Para regioes novas, diferente do que esta salvo no banco.
                if ( !isset($current[$regionName]) ) {
                    $current[$regionName]['content'] = 'NovaRegiaoDeConteudo';
                }

                $current[$regionName] = $region;
                $edited = true;
            }
        }

        $this->reg->content_regions = json_encode($current, JSON_UNESCAPED_UNICODE);
        $this->reg->save();

        $res = [
            'status' => true,
            'edited' => $edited,
        ];
        return json_encode($res);
    }

    public function updatePost($postId, $request)
    {
        $post = Post::where('id', $postId)->first();
        $currRegions = json_decode($post->content_regions, true);

        $edited = false;
        foreach($request['regions'] as $key => $region)
        {
            if ( isset($region['content']) ) {
                $edited = true;
                $currRegions[$key] = $region;
            }
        };

        if ($edited) {
            $post->content_regions = json_encode($currRegions, JSON_UNESCAPED_UNICODE);

            $post->save();
        }

        $res = [
            'edited' => $edited,
            'status' => true
        ];

        return json_encode($res);
    }

    public function createPost($request)
    {
        $content = json_encode($request['regions'], JSON_UNESCAPED_UNICODE);

        $newPost = $this->reg->Posts()->create([
            'content_regions' => $content,
            'polymorphic_from' => City::class
        ]);

        $res = [
            'message' => 'create',
            'post_id' => $newPost->id,
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

    public static function _dataTables($cities)
    {
        $json = [];
        $i = 1;
        foreach ($cities as $city)
        {
            $regId = $city['geonameId'];
            $data = [];

            $dbinfo = [];
            $dbinfo['id'] = $regId;
            $dbinfo['ll_north'] = $city['bbox']['north'];
            $dbinfo['ll_south'] = $city['bbox']['south'];
            $dbinfo['ll_east']  =  $city['bbox']['east'];
            $dbinfo['ll_west']  =  $city['bbox']['west'];

            $dbinfo['lat'] = $city['lat'];
            $dbinfo['lng'] = $city['lng'];
            $dbinfo['name'] = $city['name'];
            $dbinfo['geoadmins'] = [
                'admin1' => $city['adminName1'],
                'admin2' => $city['adminName2'],
            ];

            $configButton = [
                'html' => '+ info',
                'attributes' => [
                    'href' => 'javascript:;',
                    'data-jslistener-click' => 'country.loadInMap'
                ]
            ];

            $addButton = [
                'html' => 'adicionar',
                'attributes' => [
                    'href' => 'javascript:;',
                    'data-jslistener-click' => 'country.saveSelectedCity'
                ]
            ];

            $infoHidden = [
                'html' => json_encode($dbinfo),
                'attributes' => [
                    'id' => 'cityinfo_'.$regId,
                    'style' => 'display: none',
                    'href' => 'javascript:;',
                ]
            ];


            array_push($data, $i); //coluna "N"

            array_push($data, $regId);

            $name = $city['name'].' / '.$city['adminName1'].' / '.$city['adminName2'];

            array_push($data, $name);

            array_push($data, [
                'rowButtons' =>
                    [
                        $configButton,
                        $addButton,
                        $infoHidden,
                    ]
            ]);

            array_push($json, $data);
            $i++;
        }

        return $json;
    }

    public function setDefaults()
    {
        $this->activeCities = function (){
            return $this->activeCities(true);
        };
    }

    public function activeCities($return = false)
    {
        $this->activeCities = City::activeCities();


        if ($return) {
            return $this->activeCities;
        }else{
            return $this;
        }
    }

    public function toTable(){
        $data = [];
        $cols = [
            ['title' => 'n', 'width' => '10px'],
            ['title' => 'id', 'width' => '70px'],
            ['title' => 'nome'],
            ['title' => 'pais'],
            ['title' => 'ações', 'width' => '200px'],
        ];

        $i = 1;
        foreach ($this->activeCities as $city)
        {
            array_push($data, [
                $i,
                $city->id,
                $city->name,
                $city->Country->name,
                [
                    'rowButtons' =>
                    [
                        [
                            'html' => '+ config',
                            'attributes' =>
                                [
                                'href' => '/painel/mundo/cidade/'.$city->id,
                            ]
                        ]
                    ]
                ]
            ]);
            $i++;
        }

        $activeCities = [
            'data' => $data,
            'cols' => $cols
        ];

        return $activeCities;
    }
}

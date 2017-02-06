<?php

namespace App\Http\Controllers\Painel\Blog;

use App\City;
use App\Http\Controllers\Painel\World\CityController;
use App\Library\BlogJobs;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;
use App\Library\Jobs;
use App\Post;

class PostController extends Controller
{
    use Jobs;
    use BlogJobs;

    protected $model;
    public $reg;

    public function __construct($id)
    {
        $this->model = new Post();
        $this->reg = $this->model->where('id', $id)->get();
        $this->reg = $this->reg[0] ?? [];

        $this->vars['modulo'] = 'Blog';
        $this->vars['pageDesc'] = 'Informações do Post';
    }

    public static function manage($posts, $callbacks = []){
        return BlogJobs::manage($posts, $callbacks);
    }

    public function view(){
        return view('Painel.blog.post', $this->vars);
    }

    /*
     * Save and update???
     * */
    public function createAjaxAction(Request $request)
    {
        $res = [];
        $from = $request->screen_json['from'];

        $cityId = $request->screen_json['id'] ?? $request->screen_json['request']['city']['geonameId'];
        $city = City::where('id', $cityId)->first();
        if ( is_null($city) ){
            $data = $request->screen_json['request'];
            $cityId = $data['city']['geonameId'];
            $cityController = new CityController(0);
            $cityController->create($data['city'], $data['estate'], $data['country'], json_encode(['This city generated from PostController.']));
//            $cityController->create($data['city'], $data['estate'], $data['country'], null);
        }else{
            /* 'id' é quando tentar criar post para uma cidade ja existente.
             *  ['request']['city']['geonameId'] é quando criar + de 1 post cadastrando a cidade no primeiro.
            */
            $cityId = $request->screen_json['id'] ?? $request->screen_json['request']['city']['geonameId'];
        }

        $city = City::where('id', $cityId)->first();

        if ($from == 'city')
        {
            if (empty($request->regions))
            {
                //Cairá aqui apenas se falhar a validação do javascript das regions obrigatórias em caso de create.
                $res['status'] = false;
                $res['message'] = 'none';
            }
            else
            {
                //Criar post aqui!
                $post = [
                    'content_regions' => json_encode($request->regions, JSON_UNESCAPED_UNICODE),
                ];

                $city->Post()->create($post);

                $res['status'] = true;
                $res['message'] = 'create';
            }
        }

        return json_encode($res);
    }

    public function updateAjaxAction(Request $request){
        $res = [];
        $regions = json_decode($this->reg->content_regions, true);

        $edited = false;
        foreach ($request->regions as $name => $regionData)
        {
            if ( isset($regionData['content']) ) {
                $regions[$name]['content'] = $regionData['content'];
                $edited = true;
            }
        }

        if ($edited) {
            $this->reg->content_regions = json_encode($regions, JSON_UNESCAPED_UNICODE);
            $this->reg->save();
        }

        $res['edited'] = $edited;
        $res['message'] = 'update';
        return json_encode($res);
    }
}

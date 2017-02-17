<?php

namespace App\Http\Controllers\Painel\Blog;

use App\Authors;
use App\City;
use App\Country;
use App\Http\Controllers\Painel\World\CityController;
use App\Library\BlogJobs;
use App\Library\Headlines;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;
use App\Library\Jobs;
use App\Post;

class PostController extends Controller
{
    use Jobs;
    use BlogJobs;
    use Headlines{
        Headlines::__construct as Headlines;
    }

//    protected $model;
//    public $reg;

    public function __construct($id)
    {
        if ($id) {
            $this->getReg(Post::class, $id);
            $this->Headlines(Post::class);
            $this->vars['headlines'] = $this->reg->Headlines;
        }

        $this->vars['authors'] = Authors::all();

        $this->vars['modulo'] = 'Blog';
        $this->vars['pageDesc'] = 'Informações do Post';
    }


    public static function manage($posts, $callbacks = []){
        return BlogJobs::manage($posts, $callbacks);
    }

    public function view($request = ''){
        //Verifica se existe $_POST e executa actin
        $this->hasAction($request);

//        $f = $this->reg->polimorph_from;
//        dd($f);
//        $this->vars['parentUrl'] = $this->reg

        BlogJobs::manage($this->reg, ['getPolimorphInfo' => true]);

        return view('Painel.blog.post', $this->vars);
    }

    public function deactive(){
//        dd("here1");
        $this->reg->status = 0;
        $this->reg->save();
    }

    public function active(){
//        dd("here2");

        if (!$this->reg->author_id) {
            $PostMessage =  [
                'type' => 'error', 'title' => 'Ops!', 'text' => 'Não é possível ativar um post sem autor'
            ];
            return redirect('/painel/blog/post/'.$this->reg->id)->with('PostMessage', json_encode($PostMessage));
//            return false;
//            dd("sem autor");
//            return false;
        }

        $this->reg->status = 1;
        $this->reg->save();
    }

    public function updateAuthor($request){
//        dd($request->author);
        if ( empty($request->author) ){
            $PostMessage =  [
                'type' => 'error', 'title' => 'Selecione um Autor!', 'text' => ''
            ];
            return redirect('/painel/blog/post/'.$this->reg->id)->with('PostMessage', json_encode($PostMessage));
        }

        $this->reg->author_id = $request->author;
        $this->reg->save();
    }

    /*
     * Save and update???
     * */
    public function createAjaxAction(Request $request)
    {
//        dd($request->all());
        $res = [];
        $from = $request->screen_json['from'];

        if ($from == 'city') {
            $polyFrom = City::class;

            $cityId = $request->screen_json['id'] ?? $request->screen_json['request']['city']['geonameId'];
            $city = City::where('id', $cityId)->first();
            if ( is_null($city) ){
                $data = $request->screen_json['request'];
                $cityId = $data['city']['geonameId'];
                $cityController = new CityController(0);
                $cityController->create($data['city'], $data['estate'], $data['country'], json_encode(['This city generated from PostController.']));
                $city = City::where('id', $cityId)->first();
            }
//            else{
//                /* 'id' é quando tentar criar post para uma cidade ja existente.
//                 *  ['request']['city']['geonameId'] é quando criar + de 1 post cadastrando a cidade no primeiro.
//                */
//                $cityId = $request->screen_json['id'] ?? $request->screen_json['request']['city']['geonameId'];
//            }

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
                    'polymorphic_from' => $polyFrom
                ];

                $newPost = $city->Posts()->create($post);

                $res['status']  = true;
                $res['post_id'] = $newPost->id;
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
//            dd($regions);
            $this->reg->content_regions = json_encode($regions, JSON_UNESCAPED_UNICODE);
//            dd($this->reg->content_regions);
            $t = $this->reg->save();
        }

        $res['edited'] = $edited;
        $res['message'] = 'update';
        return json_encode($res);
    }
}

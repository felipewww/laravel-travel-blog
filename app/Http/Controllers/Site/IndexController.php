<?php

/*
 * Possibilidade de criar multiplas homes com excessões:
 *
 * - Para adicionar ITENS a uma home ja existente, só se for abaixo.
 * - Caso queria adicionar itens em blocos ja existentes, é necessário criar uma nova home, nova view
 * e novo cadastro diferenciado no banco conforme as regiões em sequencia.
 *
 * */
namespace App\Http\Controllers\Site;
use App\City;
use App\Country;
use App\Headline;
use App\Home;
use App\HomeFixeds;
use App\Http\Controllers\Controller;
use App\Library\BlogJobs;
use App\Library\Jobs;
use App\Place;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller {
    use Jobs;
    public $model;

    public $layouts = [
        '1' => [
            'regions' => [
                '1' => ['qtt' => 4],
                '2' => ['qtt' => 4],
                '3' => ['qtt' => 2]
            ],
            'total' => 10,
            'view' => 'Site.index'
        ]
    ];

    public $currLayout;

    function index(){
        $this->model = new Home();

        //todo - Fazer aqui a config de teste A/B futuramente
        $home = $this->model->where('status',true)->first();
        $this->currLayout = $this->layouts[$home->layout];

        $this->json_meta(['home_id' => $home->id]);
        $this->json_meta(['home_layout' => $home->layout]);
        $headlines = $home->headline; //ok tbm
        $fixeds = HomeFixeds::where('home_id', $home->id)
            ->with('headline')
            ->orderBy('position','ASC')
            ->get();

        /**
         * Este foreach funciona perfeitamente, mantido apenas para estuod de caso.
         * */
//        foreach ($headlines as $hl){
//            $hl->city->first(); //ok tbm!
//            dd($hl->city->first()->estate->first()->country->first()->continent); //wow! Laravel is good!
//            $hl->headline_morph->estate->country->continent;//Really, laravel is fucking good!
//            $hl->headline_morph;
//        }

        $this->vars['cities'] = City::where('status',1)->has('Headlines')->get();
        $this->vars['countries'] = Country::where('status',1)->has('Headlines')->get();
        $this->vars['places'] = Place::where('status',1)->has('Headlines')->get();

        $t = Post::where('status',1)->has('Headlines')->get();

        $this->vars['posts']    = BlogJobs::manage($t, [
            'title' => true
        ]);

        $this->vars['isAdmin'] = Auth::check();
        $this->makeRegions($fixeds, $this->currLayout['regions']);
        return view($this->currLayout['view'], $this->vars);
    }

    function createNull($i)
    {
        $notExists = new \stdClass();
        $notExists->headline = new \stdClass();

        $notExists->position = $i;
        $notExists->headline->final_id = 'noid-regionPOSITION-'.$i.'-item-'.$i;
        $notExists->headline->divClass = 'null-headline';
        $notExists->headline->title = 'Item '.$i.' da RegiãoPOSITION '.$i.' sem Headline';
        $notExists->headline->content = 'Enquanto houver espaços indefinidos, como este, não será possível exibir esta homepage no site!';
        $notExists->headline->src = 'Site/media/images/cidades/headlines/null_headline.jpg';

        return $notExists;
    }

    protected function makeRegions($fixeds, $regionsCfg){

        $total = $this->currLayout['total'];
        $itens = [];
        $i = 0;

        while ($i < $total)
        {
            if ( isset($fixeds[$i]) )
            {
                $fixed = $fixeds[$i];
                if ($fixed->position == $i)
                {
                    $this->manageHeadlineData($fixed->headline);
                    $itens[$i] = $fixed->headline;
                }
                else
                {
                    /*
                     * Só vai inserir elemento NULL se não houver nada la dentro. Afinal, algum elemento
                     * ja pode ter sido inserido antes por ter posição diferente de $i;
                     * */
                    if ( empty($itens[$i]) )
                    {
                        $itens[$i] = $this->createNull($i)->headline;
                    }
//                    $itens[$fixed->position] = $fixed->headline;
                    $this->manageHeadlineData($fixed->headline);
                    $itens[$fixed->position] = $fixed->headline;
                }
            }
            else
            {
                /*
                 * Só vai inserir elemento NULL se não houver nada la dentro. Afinal, algum elemento
                 * ja pode ter sido inserido antes por ter posição diferente de $i;
                 * */
                if ( empty($itens[$i]) )
                {
                    $itens[$i] = $this->createNull($i)->headline;
                }
            }
            $i = $i+1;
        }

        /*
         * Separar os itens em sequencia por REGIONS
         * */
        $i = 0;
        $regions = $this->currLayout['regions'];
        $finalRegions = [];
        foreach ($regions as $r_id => $region)
        {
            $finalRegions[$r_id] = [];

            $qtt = $region['qtt'];
            $totalForRegion = $i + $qtt;
            while ($i < $totalForRegion)
            {
                array_push($finalRegions[$r_id], $itens[$i]);
                $i++;
            }
        }

        $this->vars['regions'] = $finalRegions;
    }

    protected function manageHeadlineData($data)
    {
//        if ( isset($data->headline_morph_type) )
//        {
//        dd($data);
            switch ($data->polymorphic_from)
            {
                case City::class:
                    $data->final_id = 'inside_hl_cities_'.$data->id;
                    break;

                case Country::class:
                    $data->final_id = 'inside_hl_countries_'.$data->id;
                    break;

                case Post::class:
                    $data->final_id = 'inside_hl_posts_'.$data->id;
                    break;

                case Place::class:
                    $data->final_id = 'inside_hl_place_'.$data->id;
                    break;

                /*TODO*/
                case 'App\Lista':
                    $data->final_id = 'inside_hl_lists_'.$data->id;
                    break;

                /*TODO*/
                case 'App\Videos':
                    $data->final_id = 'inside_hl_videos_'.$data->id;
                    break;

                default:
                    $data->final_id = 'nothing';
                    break;
            }
//        }
    }

//    function hello($nome){
//        $html = '<b>HTML</b>';
//        return view('Site.index', ['nome' => $nome, 'html' => $html]);
//    }
//
//    public function pais(Request $request){
//        return view('Site.cidade', ['isAdmin' => Auth::check()]);
//    }
//
//    public function estado(Request $request){
//        return view('Site.cidade', ['isAdmin' => Auth::check()]);
//    }
//
//    public function cidade(Request $request){
//        return view('Site.cidade', ['isAdmin' => Auth::check()]);
//    }


    public function uploadImage(Request $request)
    {
        if ( $request->hasFile('image') ) {
            $base_path = base_path() . '/public';
            $path = '/Site/media/images/postContent/';

            $file = $request->file('image');
            $newName = time().'.'.$file->getClientOriginalExtension();

            $file->move($base_path.$path, $newName);

            $size = getimagesize($base_path.$path.$newName);
//            dd($x);

            echo json_encode([
                'url' => $path.$newName,
                'size' => [$size[0], $size[1]]
            ]);
        }else{
            trigger_error('Erro. $_FILES não existe', E_USER_ERROR);
        }
    }

    public function insertImage(){

    }

    public static function getHeadlinesApi(Request $request)
    {
        $res = [
            'status' => false
        ];

        if ($request->from == 'cities') {
            $city = City::find($request->id);
            if ( isset($city->Headlines) ) {
                $hls = $city->Headlines;
                $res['status'] = true;
            }else{
                $res['status'] = false;
                $res['message'] = 'Nenhum headline cadastrado para CIDADES';
            }

        }
        else if($request->from == 'countries')
        {
            //$res['message'] = 'Pesquisa de headlines de países não está configurada';
            $country = Country::find($request->id);
            if ( isset($country->Headlines) ) {
                $hls = $country->Headlines;
                $res['status'] = true;
            }else{
                $res['status'] = false;
                $res['message'] = 'Nenhum headline cadastrado para PAÍSES';
            }
        }
        else if($request->from == 'posts')
        {
            $post = Post::find($request->id);
            if ( isset($post->Headlines) ) {
                $hls = $post->Headlines;
                $res['status'] = true;
            }else{
                $res['status'] = false;
                $res['message'] = 'Nenhum headline cadastrado para POSTS';
            }
        }
        else if($request->from == 'place')
        {
            $place = Place::find($request->id);
//            dd($place);
            if ( isset($place->Headlines) ) {
                $hls = $place->Headlines;

//                $t = $place->Headlines()->select('id','title','src','polymorphic_from',"substr(content, 1, 100) as trim_content")->get();
//                $t = $place->Headlines()->select('substr(content, 1, 100) as trim_content')->get();
//                dd($t);
                $res['status'] = true;
            }else{
                $res['status'] = false;
                $res['message'] = 'Nenhum headline cadastrado para POSTS';
            }
        }
        else
        {
            $hls = [];
            $res['message'] = 'Parametro $from inválido. Entre em contato com o administrador.';
        }

        if ( isset($hls) ) {
            $hls_info = [];
            foreach ($hls as $hl)
            {
                $info = [
                    'id'        => $hl->id,
                    'src'       => $hl->src,
                    'title'     => $hl->title,
                    'content'   => $hl->content,
                ];

                array_push($hls_info, $info);
            }

            $res['status'] = true;
            $res['hls'] = $hls_info;
        }

        return json_encode($res);
    }

    public function updateHeadlinesApi(Request $request)
    {
        $home_id    = $request->screenJson['home_id'];

        $sended_hls = $request->ids;

        $res = [];
        $persist = false;
        $hasNull = false;

        foreach ($sended_hls as $position => $hl_info)
        {
            //Isso porque campos NULL não contém "_". somente TRAÇOS ( - )
            $hl_info = explode('_', $hl_info);
            $hl_id = $hl_info[3] ?? false;

            if ($hl_id)
            {
                $currHl = HomeFixeds::where(
                    ['position' => $position],
                    ['home_id' => $request->home_id],
                    ['headline_id' => $hl_id]
                )->first();

                if ( !empty($currHl) )
                {
                    if ($currHl->headline_id != $hl_id)
                    {
                        $persist = true;

                        DB::table("homefixeds")
                            ->where(
                                [
                                    'home_id'=> $home_id,
                                    'headline_id' => $currHl->headline_id,
                                ]
                            )
                            ->update(
                                [
                                    'headline_id' => $hl_id,
                                    'updated_at' => date('Y-m-d H-i-s'),
                                ]
                            );
//                        $currHl->save();
                        $currHl = 'UPDATE no item alterado '.$position;
                    }
                    else
                    {
                        $currHl = "item ".$position.' não foi alterado';
                    }
                }
                else
                {
                    /**
                     * TODO
                     * Aqui é o momento de verificar se ja existe um item cadastrado com as novas configurações,
                     * que seria o caso de adicionar um ITEM em uma HOME ja existente. ou seja, se ja existir,
                     * deletar e criar este novo... Será que é isso? Testar...
                     * */

                    $persist = true;
                    $data = [
                        'position' => $position,
                        'home_id' => $home_id,
                        'headline_id' => $hl_id
                    ];
                    HomeFixeds::create($data);
                    $currHl = 'criar novo na posição '.$position;
                }
            }
            else
            {
                $hasNull = true;
                $currHl = null;
            }
            array_push($res, $currHl);
        }

        if ($persist) {
            $msg = 'Houve alguma alteração no banco';
            $status = true;
        }else{
            $msg = 'Não alterou nada!';
            $status = false;
        }
        $res['status']  = $status;
        $res['msg']     = $msg;
        $res['hasNull'] = $hasNull;

        return json_encode($res);
    }
}
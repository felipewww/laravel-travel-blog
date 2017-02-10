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
use App\Headline;
use App\Home;
use App\Http\Controllers\Controller;
use App\Library\Jobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            'view' => 'Site.index'
        ]
    ];

    public $currLayout;

    function index(){
        $this->model = new Home();

        //todo - Fazer aqui a config de teste A/B futuramente
        $home = $this->model->where('status',true)->first();
        $this->currLayout = $this->layouts[$home->layout];

        $headlines = $home->headline; //ok tbm
//        $headlines = $home->headline()->with('city')->orderBy('position')->get(); //ok
//        $this->manageHeadlines($headlines);
//        dd($headlines);

        /*
         * Este foreach funciona perfeitamente, mantido apenas para estuod de caso.
         * */
//        foreach ($headlines as $hl){
//            $hl->city->first(); //ok tbm!
//            dd($hl->city->first()->estate->first()->country->first()->continent); //wow! Laravel is good!
//            $hl->headline_morph->estate->country->continent;//Really, laravel is fucking good!
//            $hl->headline_morph;
//        }

        $this->vars['cities'] = City::has('Headline')->get();
        $this->vars['isAdmin'] = Auth::check();
        $this->makeRegions($headlines, $this->currLayout['regions']);

        return view($this->currLayout['view'], $this->vars);
    }

    protected function makeRegions($headlines, $regionsCfg){
        $regions = [];
        foreach ($regionsCfg as $idx => $cfg)
        {
            $qtt = $cfg['qtt'];
            $regions[$idx] = [];
            $i = 0;
            while ($i < $qtt)
            {
                $notExists = new \stdClass();

                //fazer isso para evitar bugs com duplicidade de ID no HTMl e JS
                $notExists->final_id = 'noid-region-'.$idx.'-item-'.$i;
                $notExists->divClass = 'null-headline';
                $notExists->title = 'Item '.$i.' da Região '.$idx.' sem Headline';
                $notExists->content = 'Enquanto houver espaços indefinidos, como este, não será possível exibir esta homepage no site!';
                $notExists->src = 'Site/media/images/cidades/headlines/null_headline.jpg';

                $data = $headlines[$i] ?? $notExists;
                $this->manageHeadlineData($data);
                array_push($regions[$idx], $data);
                unset($headlines[$i]);
                $i++;
            }
        }
//        dd($regions);
        $this->vars['regions'] = $regions;
//        dd($regions);
    }

    protected function manageHeadlineData($data)
    {
        if ( isset($data->headline_morph_type) )
        {
            switch ($data->headline_morph_type)
            {
                case City::class:
                    $data->final_id = 'inside_hl_cities_'.$data->id;
                    break;
            }
        }
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
            $hls = $city->Headline;
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

        }else if($request->from == 'countries')
        {
            $res['message'] = 'Pesquisa de headlines de países não está configurada';
        }
        else{
            $res['message'] = 'Parametro $from inválido. Entre em contato com o administrador.';
        }

        return json_encode($res);
    }

    public static function updateHeadlinesApi(Request $request)
    {
        dd($request->all());
    }
}
<?php

namespace App\Http\Controllers\Painel\Interests;

use App\Library\DataTablesInterface;
use App\Library\DataTablesExtensions;
use \App\Http\Controllers\Controller;
use App\Library\Jobs;
use Illuminate\Http\Request;
use App\Interest;
use App\City;

class InterestController extends Controller implements DataTablesInterface
{
    use Jobs;
    use DataTablesExtensions;

//    protected $model;
    public $all;
//    public $all2;

    public function __construct()
    {
        $this->model = new Interest();
        $this->getAll();

        $this->vars['modulo'] = 'Interesses';
        $this->vars['pageDesc'] = 'Listagem e cadastro de Interesses';
    }

    public function getAll()
    {
        $this->all = $this->model->all();

        $final = [];
        foreach ($this->all as $in)
        {
            $reg = $in->getAttributes();
            array_push($final, $reg);
        }

        $this->all = $final;
//        dd($final);
    }

    public function dataTablesConfig()
    {
        $data = [];
        $i = 1;

        foreach ($this->all as $reg)
        {
            //$reg = $in->getAttributes();

            $cInfo = [
                $i,
                $reg['id'],
                $reg['name'],
                //$reg['color'],
                [
                    'bgColor' => $reg['color']
                ],
                [
                    'rowButtons' =>
                    [
                        [
                            'html' => '+ editar',
                            'attributes' => ['data-jslistener-click' => 'ints.edit']
                        ],
                        [
                            'html' => 'excluir',
                            'attributes' => ['data-jslistener-click' => 'ints.delete']
                        ]
                    ]
                ],
            ];
            array_push($data,$cInfo);
            $i++;
        }

        $this->data_info = $data;

        $this->data_cols = [
            ['title' => 'n', 'width' => '10px'],
            ['title' => 'id', 'width' => '40px'],
            ['title' => 'nome'],
            ['title' => 'cor'],
            ['title' => 'ações', 'width' => '120px'],
        ];
    }

    public function action(Request $request){

        if (!isset($request->action)) {
            throw new \Error('Falta action');
        }

        if ($request->action == 'create') {
            Interest::create($request->all());
        }
        else if ($request->action == 'delete') {
            $interest = Interest::find($request->id);
            $interest->delete();
        }
        else if ($request->action == 'update') {
            $interest = Interest::find($request->id);
            $interest->name = $request->name;
            $interest->color = $request->color;
            $interest->save();
        }

        return redirect('/painel/interesses');
    }

    public function store(Request $request){

        //Interest::create($request->all());
        //return redirect('/painel/interesses');
    }

    public function display()
    {
        $this->dataTablesInit();
        return view('Painel.interests.interests', $this->vars);
    }
}

<?php

namespace App\Http\Controllers\Painel\World;

use App\Library\DataTablesInterface;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;
use Painel\World\City;

class CityController extends Controller {

    use \App\Library\Jobs;

    protected $city;

    public function __construct($city)
    {
        $this->city = City::where('id', $city)->get();

        if ( isset($this->city[0]) ) {
            $this->city = $this->city[0]->getAttributes();
        }else{
            trigger_error('Esta cidade ainda não está cadastrada no banco. Favor gerar um Blog/Post para depois editar suas configurações', E_USER_ERROR);
        }

        $this->vars['city'] = $this->city;

        $this->vars['modulo'] = 'Cidade';
        $this->vars['pageDesc'] = 'Configurações da cidade: '.$this->city['name'];
    }

    function display()
    {
        return view('Painel.world.city', $this->vars);
    }

//    function store(Request $request)
//    {
//        $this->model->store( $request->all() );
//        $this->vars['status'] = 'success';
//        return view('Painel.world.country', $this->vars);
//    }
}

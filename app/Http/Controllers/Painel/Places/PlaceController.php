<?php

namespace App\Http\Controllers\Painel\Places;

use App\City;
use App\Editorial;
use \App\Http\Controllers\Controller;
use App\Library\Headlines;
use App\Library\Jobs;
use App\Library\photoGallery;
use App\Place;
use Doctrine\DBAL\Schema\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlaceController extends Controller {

    use Jobs;

    use Headlines{
        Headlines::__construct as Headlines;
    }

    use photoGallery {
        photoGallery::__construct as photoGallery;
    }

    public $action;
    public $fromSpecificCity = false;

    public function __construct($id)
    {
        $this->model = new Place();
        $this->reg = $this->model->where('id', $id)->first();
        $this->action = ( $this->reg ) ? 'update' : 'create' ;

        if ($this->action == 'create') {
            $this->createNullReg();
            $this->reg->headlines = [];
        }

        $this->vars['action'] = $this->action;
        $this->vars['reg'] = $this->reg;
        $this->vars['from'] = Place::class;
        $this->vars['editorials'] = Editorial::all();
        $this->vars['cities'] = City::all();
    }

    public function newFromCity($city_id){

//        $itens = ;
//        $itens['cities_id'] = $city_id;
//        dd($itens);
        $this->fromSpecificCity = $city_id;
        $act = $this->hasAction(Request::capture());

        $this->vars['reg']->cities_id = $city_id;
        $this->vars['disableSelectCity'] = true;

        if ($act != false) {
            $PostMessage =  [
                'type' => 'success', 'title' => 'Feito!', 'text' => 'Item de Explore cadastrado com sucesso'
            ];

            return redirect('/painel/mundo/cidade/'.$city_id)->with('PostMessage',json_encode($PostMessage));
        }else{
            return $this->display();
        }
    }

    public function view(Request $request)
    {
        $act = $this->hasAction($request);

        if ($this->action == 'update') {
            $this->Headlines(Place::class);
            $this->photoGallery(Place::class);
        }

        return $this->display($act);
    }

    public function create($request)
    {
        $photo = Jobs::uploadImage($request->main_photo, "Site/media/images/places",
            [
                'shape' => 'square',
                'max-width' => 400,
            ]
        );

        $this->reg = $request->all();
        $this->reg['main_photo'] = $photo->fullpath;

        if ($this->fromSpecificCity) {
            $this->reg['cities_id'] = $this->fromSpecificCity;
        }

        $new = $this->model->create($this->reg);

        $PostMessage =  [
            'type' => 'success', 'title' => 'Feito!', 'text' => $new->title.' cadastrado com sucesso!'
        ];

        return redirect('/painel/servicos/servico/'.$new->id)->with('PostMessage',json_encode($PostMessage));
    }

    public function update($request)
    {
        if ( isset($request->main_photo) ) {
            unlink(base_path()."/public/".$this->reg->main_photo);
            $photo = Jobs::uploadImage($request->main_photo, "Site/media/images/places",
                [
                    'shape' => 'square',
                    'max-width' => 400,
                ]
            );
            $this->reg->main_photo = $photo->fullpath;
        }

        $attrs = $this->reg->getAttributes();

        foreach ($attrs as $column => $value)
        {
            if ( isset($request->$column) && $column != 'main_photo' ) {
                $this->reg->$column = $request->$column;
            }
        }

        $this->reg->save();

        $PostMessage =  [
            'type' => 'success', 'title' => 'Feito!', 'text' => $this->reg->title.' atualizado com sucesso!'
        ];

        return redirect('/painel/servicos/servico/'.$this->reg->id)->with('PostMessage',json_encode($PostMessage));
    }

    public function display($act = false){
//        dd($act);
        if ($this->action == 'create' && $act) {
//            dd("here");
            return $act;
        }else{
//            dd('here2');
            return view('Painel.places.place', $this->vars);
        }
    }

//    public function createNullReg()
//    {
//        $this->createNullReg();
//
//    }
}

<?php

//namespace app\Models\Painel;
namespace Painel\World;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $timestamps = false;
    public $fillable = ['name', 'sigla_2', 'sigla_3'];

    public function Post()
    {
        return $this->morphMany(Post::class, 'polimorph_from');
    }

    public function generateFakePost($city_id = false, $quantity = 1)
    {
        Post::generateFake($city_id);
    }

    public function continent()
    {
//        return $this->hasOne(\Painel\World\Continent::class, 'id', 'continents_id');
        return $this->belongsTo(\Painel\World\Continent::class, 'continents_id');
    }

    /**
     * Sobreposição de método
     * */
//    public static function create()
//    {
//
//        $c          = new Continent();
//        $continent  = $c->find($id);
//
//        if ($continent){
//            $continent->country()->create();
//        }
//    }
}

//function(){
//    $cont = new \Painel\World\Continent();
//    $c = $cont->find(1);
//
//    $country = new \Painel\World\Country();
//
//    $cy = ['name'=>'Test', 'sigla_2' => 'TS', 'sigla_3' => 'TES'];
//
//    $country->continent(1)->create($cy);
//}
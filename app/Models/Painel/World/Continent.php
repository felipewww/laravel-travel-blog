<?php

namespace Painel\World;

use Illuminate\Database\Eloquent\Model;

class Continent extends Model
{
    public $timestamps = false;

    public function country()
    {
//        return $this->belongsTo(\Painel\World\Country::class, 'id');
        return $this->hasOne(\Painel\World\Country::class, 'continents_id', 'id');
    }
}

//function(){
//    $c = new \Painel\World\Continent();
//    $cont = $c->find(1);
//    $country = ['name'=>'Test', 'sigla_2' => 'TS', 'sigla_3' => 'TES'];
//    $cont->country()->create($country);
//}
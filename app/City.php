<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Painel\Interests\Interest;

class City extends Model
{
    public function Post()
    {
        return $this->morphMany(\Post::class, 'polimorph_from');
    }

    public function Headline()
    {
        return $this->morphMany(\Headline::class, 'polimorph_from');
    }

    public function interests()
    {
        return $this->belongsToMany(\Interest::class, 'city_has_interests', 'cities_id', 'interests_id');
//        return $this->belongsToMany(City::class, 'city_has_interests', 'cities_id', 'interests_id');
    }

    /*
     * Ler posts da cidade
     * Painel\City::with('Post')->get()
     * */
}

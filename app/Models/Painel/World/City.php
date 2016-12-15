<?php

namespace Painel\World;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function Post()
    {
        return $this->morphMany(Post::class, 'polimorph_from');
    }

    public function interests()
    {
        return $this->belongsToMany(\Painel\Interests\CityHasInterest::class, 'cities_has_interests', 'cities_id', 'interests_id');
    }

    /*
     * Ler posts da cidade
     * Painel\City::with('Post')->get()
     * */
}

<?php

namespace Painel\Interests;

use Illuminate\Database\Eloquent\Model;

class CityHasInterest extends Model
{
    public function cities()
    {
        return $this->belongsToMany(\Painel\World\City::class, 'cities_has_interests', 'interests_id', 'cities_id');
    }
}

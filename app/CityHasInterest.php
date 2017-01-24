<?php

use Illuminate\Database\Eloquent\Model;

class CityHasInterest extends Model
{
    public function cities()
    {
        return $this->belongsToMany(City::class, 'cities_has_interests', 'interests_id', 'cities_id');
    }

    public function places()
    {
        return $this->belongsToMany(Place::class, 'places_has_interests', 'interests_id', 'places_id');
    }
}

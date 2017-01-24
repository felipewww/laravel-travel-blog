<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Continent extends Model
{
    public $timestamps = false;

    public function country()
    {
        return $this->hasOne(Country::class, 'continents_id', 'id');
    }
}
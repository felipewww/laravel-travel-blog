<?php

namespace Painel\Places;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    //

    public function photos()
    {
        return $this->belongsToMany(\Painel\Interests\PlaceHasInterest::class, 'places_has_interests', 'places_id', 'interests_id');
    }
}

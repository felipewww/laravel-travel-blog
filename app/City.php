<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function Posts()
    {
        return $this->belongsToMany(Post::class, 'cities_has_posts', 'city_id', 'post_id');
    }

    public function Headlines()
    {
        return $this->belongsToMany(Headline::class, 'cities_has_headlines', 'city_id', 'headline_id');
    }

    public function Interests()
    {
        return $this->belongsToMany(Interest::class, 'cities_has_interests', 'city_id', 'interest_id');
    }

    public function estate()
    {
        return $this->belongsTo(Estate::class, 'estates_id');
    }

    public function Places()
    {
        return $this->hasMany(Place::class, 'cities_id');
    }
}

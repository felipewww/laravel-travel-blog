<?php

namespace App;

use App\Headline;
use App\Post;
use Illuminate\Database\Eloquent\Model;
//use Painel\Interests\Interest;
//use App\Post;
//use App\Headline;

class City extends Model
{
//    public function Post()
//    {
//        return $this->morphMany(Post::class, 'polimorph_from');
//    }
//
//    public function Headline()
//    {
//        return $this->morphMany(Headline::class, 'headline_morph');
//    }

    public function Posts()
    {
        return $this->belongsToMany(Post::class, 'cities_has_posts', 'city_id', 'post_id');
//        return $this->belongsToMany(City::class, 'city_has_interests', 'cities_id', 'interests_id');
    }

    public function Headlines()
    {
        return $this->belongsToMany(Headline::class, 'cities_has_headlines', 'city_id', 'headline_id');
    }

    public function interests()
    {
        return $this->belongsToMany(Interest::class, 'cities_has_interests', 'city_id', 'interest_id');
//        return $this->belongsToMany(City::class, 'city_has_interests', 'cities_id', 'interests_id');
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

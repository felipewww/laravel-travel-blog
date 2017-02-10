<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Painel\Interests\Interest;
use App\Post;
use App\Headline;

class City extends Model
{
    public function Post()
    {
        return $this->morphMany(Post::class, 'polimorph_from');
    }

    public function Headline()
    {
        return $this->morphMany(Headline::class, 'headline_morph');
    }

    public function interests()
    {
        return $this->belongsToMany(\Interest::class, 'city_has_interests', 'cities_id', 'interests_id');
//        return $this->belongsToMany(City::class, 'city_has_interests', 'cities_id', 'interests_id');
    }

    public function estate()
    {
        return $this->belongsTo(Estate::class, 'estates_id');
    }
}

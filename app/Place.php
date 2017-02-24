<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Place extends Model
{
    public $fillable = ['title','content','cities_id','editorials_id','search_tags','seo_tags','main_photo'];

    public function Interests()
    {
//        return $this->belongsToMany(Interest::class, 'place_has_interests', 'place_id', 'interest_id');
        return $this->belongsToMany(Interest::class, 'places_has_interests');
    }

    public function Photos()
    {
        return $this->hasMany(PlacePhotos::class);
    }

    public function Events()
    {
        return $this->belongsToMany(Event::class, 'places_has_events', 'place_id', 'event_id');
    }

    public function Headlines()
    {
        return $this->belongsToMany(Headline::class, 'places_has_headlines', 'place_id', 'headline_id');
    }

    public function City()
    {
        return $this->belongsTo(City::class, 'cities_id');
    }
}

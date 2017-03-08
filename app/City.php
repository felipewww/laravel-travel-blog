<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $fillable = ['id', 'name', 'll_north', 'll_south', 'll_east', 'll_west', 'lat', 'lng', 'country_id', 'geoadmins'];

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

//    public function estate()
//    {
//        return $this->belongsTo(Estate::class, 'estates_id');
//    }

    public function Country()
    {
//        return $this->belongsTo(Country::class, 'country_id');
        return $this->belongsTo(Country::class);
    }

    public function Places()
    {
        return $this->hasMany(Place::class, 'cities_id');
    }

    public function Photos()
    {
        return $this->hasMany(CityPhotos::class);
    }

    public static function activeCities()
    {
        $cities = City::
        select('id','name','geoadmins','country_id')
//            ->with('country')
            ->with('Country')
            ->where(['status' => 1])
            ->whereNotNull('content_regions')
            ->orderBy('name')
            ->get();

        return $cities;
    }

    public function activeCitiesDataTables($c)
    {
        $cities = $this->activeCities;

    }
}

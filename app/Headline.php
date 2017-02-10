<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Headline extends Model
{
    public $fillable = ['title', 'content', 'src'];
//    public function polimorph_from()
//    {
//        return $this->morphTo();
//    }

    public function headline_morph()
    {
        return $this->morphTo();
    }

    //Isso é a mesma coisa que headline_morph, apenas para questão de estudos.
    public function city()
    {
        return $this->morphedByMany('App\City', 'headline_morph', 'headlines', 'id');
    }

    public function home()
    {
        return $this->belongsToMany(Home::class, 'homefixeds', 'headline_id', 'home_id');
//            ->withTimestamps();
    }
}

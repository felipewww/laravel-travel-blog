<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    public function headline()
    {
        return $this->belongsToMany(Headline::class, 'homefixeds', 'home_id', 'headline_id')->withPivot('position');
//            ->withTimestamps();
    }
}

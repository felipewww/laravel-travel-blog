<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Headline extends Model
{
    public function polimorph_from()
    {
        return $this->morphTo();
    }
}

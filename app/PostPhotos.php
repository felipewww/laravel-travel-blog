<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostPhotos extends Model
{
    public $fillable = ['path','places_id','position'];
    public $timestamps = false;
}

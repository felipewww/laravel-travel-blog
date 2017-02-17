<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlacePhotos extends Model
{
    public $fillable = ['path','places_id'];
}

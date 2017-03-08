<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CityPhotos extends Model
{
    public $fillable = ['path','city_id', 'position'];
    public $timestamps = false;
}

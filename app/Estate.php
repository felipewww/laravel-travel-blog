<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    protected $fillable = ['name'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'countries_id');
    }
}

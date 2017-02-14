<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeFixeds extends Model
{
    //
    public $table = 'homefixeds';
    public $fillable = ['position', 'home_id', 'headline_id'];

    protected $primaryKey = null;
    public $incrementing = false;

    public function headline()
    {
        return $this->belongsTo('App\Headline');
    }
}

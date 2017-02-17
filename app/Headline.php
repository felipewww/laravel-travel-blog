<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Headline extends Model
{
    public $fillable = ['title', 'content', 'src', 'polymorphic_from'];

    /*
     * todo - ao invés de morphTo(). Criar uma função nova para substituir o polimorifsmo do laravel.
     * O mesmo para EVENT e POST
     * */
    public function polymorphic_from(){
        //todo... criar função
    }

    public function home()
    {
        return $this->belongsToMany(Home::class, 'homefixeds', 'headline_id', 'home_id');
//            ->withTimestamps();
    }
}
